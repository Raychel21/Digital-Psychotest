<?php

namespace Tests\Feature;

use App\Actions\Participant\SaveAnswer;
use App\Actions\Participant\SubmitAttempt;
use App\Enums\AttemptStatus;
use App\Enums\QuestionType;
use App\Models\Answer;
use App\Models\Assessment;
use App\Models\Attempt;
use App\Models\Option;
use App\Models\Question;
use App\Models\TestResult;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RunnerUpgradeTest extends TestCase
{
    use RefreshDatabase;

    public function test_complete_ranking_order_is_saved(): void
    {
        [$attempt, $question, $options] = $this->makeRankingAttempt();
        $ordered = [$options[2]->id, $options[0]->id, $options[1]->id];

        app(SaveAnswer::class)->handle($attempt, $question, ['ordered_option_ids' => $ordered]);

        $this->assertSame(
            ['ordered_option_ids' => $ordered],
            $attempt->answers()->where('question_id', $question->id)->first()?->payload,
        );
    }

    public function test_ranking_order_missing_an_option_is_rejected(): void
    {
        [$attempt, $question, $options] = $this->makeRankingAttempt();

        $this->expectException(ValidationException::class);

        app(SaveAnswer::class)->handle($attempt, $question, [
            'ordered_option_ids' => [$options[0]->id, $options[1]->id],
        ]);
    }

    public function test_ranking_order_with_duplicate_option_is_rejected(): void
    {
        [$attempt, $question, $options] = $this->makeRankingAttempt();

        $this->expectException(ValidationException::class);

        app(SaveAnswer::class)->handle($attempt, $question, [
            'ordered_option_ids' => [$options[0]->id, $options[0]->id, $options[1]->id],
        ]);
    }

    public function test_ranking_answer_satisfies_required_validation_on_submit(): void
    {
        [$attempt, $question, $options] = $this->makeRankingAttempt();

        app(SaveAnswer::class)->handle($attempt, $question, [
            'ordered_option_ids' => $options->pluck('id')->all(),
        ]);

        $result = app(SubmitAttempt::class)->handle($attempt);

        $this->assertInstanceOf(TestResult::class, $result);
        $this->assertSame(AttemptStatus::Completed, $attempt->refresh()->status);
    }

    public function test_save_answer_is_rejected_after_time_limit_expires(): void
    {
        [$attempt, $question, $option] = $this->makeExpiredAttempt();

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Waktu pengerjaan telah habis');

        app(SaveAnswer::class)->handle($attempt, $question, ['option_id' => $option->id]);
    }

    public function test_expired_attempt_is_auto_submitted_without_required_validation(): void
    {
        [$attempt] = $this->makeExpiredAttempt();

        $result = app(SubmitAttempt::class)->handle($attempt);

        $this->assertInstanceOf(TestResult::class, $result);
        $this->assertDatabaseHas('test_results', ['attempt_id' => $attempt->id]);
        $this->assertSame(AttemptStatus::Completed, $attempt->refresh()->status);
    }

    public function test_hidden_question_is_skipped_in_required_validation_and_its_answer_pruned(): void
    {
        [$attempt, $q1, $optionA, $optionB, $q2, $q2Option] = $this->makeConditionalAttempt();

        // Jawaban q1 = B membuat q2 tersembunyi; jawaban lama q2 harus dipangkas.
        Answer::factory()->for($attempt)->for($q1)->forOption($optionB->id)->create();
        Answer::factory()->for($attempt)->for($q2)->forOption($q2Option->id)->create();

        app(SubmitAttempt::class)->handle($attempt);

        $this->assertDatabaseMissing('answers', ['attempt_id' => $attempt->id, 'question_id' => $q2->id]);
        $this->assertDatabaseHas('answers', ['attempt_id' => $attempt->id, 'question_id' => $q1->id]);
        $this->assertDatabaseHas('test_results', ['attempt_id' => $attempt->id]);
    }

    public function test_visible_required_question_still_blocks_submission(): void
    {
        [$attempt, $q1, $optionA] = $this->makeConditionalAttempt();

        // Jawaban q1 = A membuat q2 tampil; q2 wajib namun belum dijawab.
        Answer::factory()->for($attempt)->for($q1)->forOption($optionA->id)->create();

        try {
            app(SubmitAttempt::class)->handle($attempt);
            $this->fail('SubmitAttempt seharusnya menolak karena soal wajib nomor 2 belum dijawab.');
        } catch (ValidationException $exception) {
            $this->assertStringContainsString('nomor 2', $exception->getMessage());
        }

        $this->assertSame(AttemptStatus::InProgress, $attempt->refresh()->status);
    }

    /**
     * @return array{0: Attempt, 1: Question, 2: Collection<int, Option>}
     */
    private function makeRankingAttempt(): array
    {
        $assessment = Assessment::factory()->published()->create();

        $question = Question::factory()->for($assessment)->create([
            'type' => QuestionType::Ranking,
            'sort' => 1,
        ]);

        $options = Option::factory()
            ->count(3)
            ->for($question)
            ->sequence(['sort' => 1], ['sort' => 2], ['sort' => 3])
            ->create();

        $attempt = Attempt::factory()->for($assessment)->create();

        return [$attempt, $question, $options];
    }

    /**
     * Attempt dengan batas 30 menit yang dimulai 31 menit lalu, plus satu soal wajib tanpa jawaban.
     *
     * @return array{0: Attempt, 1: Question, 2: Option}
     */
    private function makeExpiredAttempt(): array
    {
        $assessment = Assessment::factory()->published()->create([
            'settings' => ['time_limit_minutes' => 30],
        ]);

        $question = Question::factory()->for($assessment)->create(['sort' => 1]);
        $option = Option::factory()->for($question)->create(['sort' => 1]);

        $attempt = Attempt::factory()->for($assessment)->create([
            'started_at' => now()->subMinutes(31),
        ]);

        return [$attempt, $question, $option];
    }

    /**
     * Soal q2 (wajib) hanya tampil bila q1 dijawab dengan opsi A.
     *
     * @return array{0: Attempt, 1: Question, 2: Option, 3: Option, 4: Question, 5: Option}
     */
    private function makeConditionalAttempt(): array
    {
        $assessment = Assessment::factory()->published()->create();

        $q1 = Question::factory()->for($assessment)->create(['sort' => 1]);
        $optionA = Option::factory()->for($q1)->create(['sort' => 1]);
        $optionB = Option::factory()->for($q1)->create(['sort' => 2]);

        $q2 = Question::factory()->for($assessment)->create([
            'sort' => 2,
            'required' => true,
            'logic' => ['visible_if' => ['==' => [['var' => "answers.{$q1->id}.option_id"], $optionA->id]]],
        ]);
        $q2Option = Option::factory()->for($q2)->create(['sort' => 1]);

        $attempt = Attempt::factory()->for($assessment)->create();

        return [$attempt, $q1, $optionA, $optionB, $q2, $q2Option];
    }
}
