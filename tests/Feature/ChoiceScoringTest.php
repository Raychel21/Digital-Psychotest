<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Assessment;
use App\Models\Attempt;
use App\Models\Dimension;
use App\Models\Option;
use App\Models\Question;
use App\Services\Scoring\RawScoreCalculator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChoiceScoringTest extends TestCase
{
    use RefreshDatabase;

    private Assessment $assessment;

    private Attempt $attempt;

    protected function setUp(): void
    {
        parent::setUp();

        $this->assessment = Assessment::factory()->published()->create();

        Dimension::factory()->for($this->assessment)->create(['code' => 'D', 'sort' => 1]);
        Dimension::factory()->for($this->assessment)->create(['code' => 'I', 'sort' => 2]);

        $this->attempt = Attempt::factory()->completed()->for($this->assessment)->create();
    }

    public function test_single_choice_sums_points_across_multiple_dimensions(): void
    {
        $this->answerSingleChoiceQuestion();

        $this->assertSame(
            ['sum' => ['D' => 2, 'I' => 1]],
            new RawScoreCalculator()->calculate($this->attempt),
        );
    }

    public function test_likert_scores_only_the_selected_option(): void
    {
        $this->answerLikertQuestion();

        $this->assertSame(
            ['sum' => ['D' => 4, 'I' => 0]],
            new RawScoreCalculator()->calculate($this->attempt),
        );
    }

    public function test_multiple_choice_sums_all_selected_options(): void
    {
        $this->answerMultipleChoiceQuestion();

        $this->assertSame(
            ['sum' => ['D' => 4, 'I' => 2]],
            new RawScoreCalculator()->calculate($this->attempt),
        );
    }

    public function test_text_questions_are_ignored_by_the_calculator(): void
    {
        $this->answerTextQuestion();

        $this->assertSame([], new RawScoreCalculator()->calculate($this->attempt));
    }

    public function test_mixed_question_types_accumulate_into_a_single_sum_scale(): void
    {
        $this->answerSingleChoiceQuestion();
        $this->answerLikertQuestion();
        $this->answerMultipleChoiceQuestion();
        $this->answerTextQuestion();

        $this->assertSame(
            ['sum' => ['D' => 10, 'I' => 3]],
            new RawScoreCalculator()->calculate($this->attempt),
        );
    }

    private function answerSingleChoiceQuestion(): void
    {
        $question = Question::factory()->for($this->assessment)->create(['sort' => 1]);
        $selected = Option::factory()->for($question)->withScores(['D' => 2, 'I' => 1])->create(['sort' => 1]);
        Option::factory()->for($question)->withScores(['I' => 3])->create(['sort' => 2]);

        Answer::factory()->for($this->attempt)->for($question)->forOption($selected->id)->create();
    }

    private function answerLikertQuestion(): void
    {
        $question = Question::factory()->likert()->for($this->assessment)->create(['sort' => 2]);

        $options = collect(range(1, 5))->map(
            fn (int $points): Option => Option::factory()
                ->for($question)
                ->withScores(['D' => $points])
                ->create(['sort' => $points]),
        );

        Answer::factory()->for($this->attempt)->for($question)->forOption($options[3]->id)->create();
    }

    private function answerMultipleChoiceQuestion(): void
    {
        $question = Question::factory()->multipleChoice()->for($this->assessment)->create(['sort' => 3]);
        $first = Option::factory()->for($question)->withScores(['D' => 1, 'I' => 2])->create(['sort' => 1]);
        Option::factory()->for($question)->withScores(['I' => 5])->create(['sort' => 2]);
        $third = Option::factory()->for($question)->withScores(['D' => 3])->create(['sort' => 3]);

        Answer::factory()
            ->for($this->attempt)
            ->for($question)
            ->forOptions([$first->id, $third->id])
            ->create();
    }

    private function answerTextQuestion(): void
    {
        $question = Question::factory()->text()->for($this->assessment)->create(['sort' => 4]);

        Answer::factory()
            ->for($this->attempt)
            ->for($question)
            ->create(['payload' => ['text' => 'Jawaban bebas yang tidak dinilai.']]);
    }
}
