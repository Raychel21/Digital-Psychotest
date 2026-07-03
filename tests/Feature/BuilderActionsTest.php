<?php

namespace Tests\Feature;

use App\Actions\Builder\AddQuestion;
use App\Actions\Builder\DuplicateQuestion;
use App\Actions\Builder\ReorderQuestions;
use App\Actions\Builder\SaveQuestionLogic;
use App\Actions\Builder\UpdateOption;
use App\Enums\QuestionType;
use App\Models\Assessment;
use App\Models\Dimension;
use App\Models\Option;
use App\Models\Question;
use App\Services\Logic\LogicEvaluator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuilderActionsTest extends TestCase
{
    use RefreshDatabase;

    private Assessment $assessment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->assessment = Assessment::factory()->create();

        Dimension::factory()->for($this->assessment)->create(['code' => 'D', 'sort' => 1]);
        Dimension::factory()->for($this->assessment)->create(['code' => 'I', 'sort' => 2]);
    }

    public function test_add_question_appends_to_bottom_with_a_default_option(): void
    {
        Question::factory()->for($this->assessment)->create(['sort' => 1]);

        $question = new AddQuestion()->handle($this->assessment, QuestionType::SingleChoice);

        $this->assertSame(2, $question->sort);
        $this->assertSame(QuestionType::SingleChoice, $question->type);
        $this->assertTrue($question->required);
        $this->assertCount(1, $question->options);
        $this->assertSame('Opsi 1', $question->options->first()->label);
    }

    public function test_add_text_question_has_no_options(): void
    {
        $question = new AddQuestion()->handle($this->assessment, QuestionType::Text);

        $this->assertSame(1, $question->sort);
        $this->assertCount(0, $question->options);
    }

    public function test_duplicate_question_copies_options_and_scores(): void
    {
        $original = Question::factory()->for($this->assessment)->create([
            'sort' => 1,
            'text' => 'Soal asli',
            'logic' => ['visible_if' => ['==' => [['var' => 'answers.9.option_id'], 5]]],
        ]);
        Option::factory()->for($original)->withScores(['D' => 2, 'I' => 1])->create(['label' => 'Opsi A', 'sort' => 1]);
        Option::factory()->for($original)->withScores(['I' => 3])->create(['label' => 'Opsi B', 'sort' => 2]);
        $after = Question::factory()->for($this->assessment)->create(['sort' => 2]);

        $copy = new DuplicateQuestion()->handle($original);

        $this->assertNotSame($original->id, $copy->id);
        $this->assertSame('Soal asli', $copy->text);
        $this->assertSame(2, $copy->sort);
        $this->assertSame(3, $after->fresh()->sort);
        $this->assertSame($original->logic, $copy->logic);

        $this->assertSame(
            [['Opsi A', ['D' => 2, 'I' => 1]], ['Opsi B', ['I' => 3]]],
            $copy->options->map(fn (Option $option): array => [$option->label, $option->scores])->all(),
        );
        $this->assertEmpty($original->options->pluck('id')->intersect($copy->options->pluck('id')));
    }

    public function test_reorder_questions_persists_sort_for_all(): void
    {
        $first = Question::factory()->for($this->assessment)->create(['sort' => 1]);
        $second = Question::factory()->for($this->assessment)->create(['sort' => 2]);
        $third = Question::factory()->for($this->assessment)->create(['sort' => 3]);

        new ReorderQuestions()->handle($this->assessment, [(string) $third->id, (string) $first->id, (string) $second->id]);

        $this->assertSame(1, $third->fresh()->sort);
        $this->assertSame(2, $first->fresh()->sort);
        $this->assertSame(3, $second->fresh()->sort);
    }

    public function test_question_logic_round_trips_and_drives_visibility(): void
    {
        $question = Question::factory()->for($this->assessment)->create(['sort' => 1]);
        $rule = ['==' => [['var' => 'answers.12.option_id'], 5]];
        $workspace = ['blocks' => ['languageVersion' => 0, 'blocks' => [['type' => 'pt_banding']]]];

        new SaveQuestionLogic()->handle($question, $rule, $workspace);

        $fresh = $question->fresh();
        $this->assertSame($rule, $fresh->logic['visible_if']);
        $this->assertSame($workspace, $fresh->logic['workspace']);

        $evaluator = new LogicEvaluator;
        $this->assertTrue($evaluator->isQuestionVisible($fresh, ['answers' => ['12' => ['option_id' => 5]]]));
        $this->assertFalse($evaluator->isQuestionVisible($fresh, ['answers' => ['12' => ['option_id' => 7]]]));
    }

    public function test_empty_logic_workspace_clears_question_logic(): void
    {
        $question = Question::factory()->for($this->assessment)->create([
            'sort' => 1,
            'logic' => ['visible_if' => ['!' => [['var' => 'answers.1.text']]]],
        ]);

        new SaveQuestionLogic()->handle($question, null, null);

        $this->assertNull($question->fresh()->logic);
    }

    public function test_update_option_translates_virtual_score_fields_via_mapper(): void
    {
        $mostLeast = Question::factory()->mostLeast()->for($this->assessment)->create(['sort' => 1]);
        $option = Option::factory()->for($mostLeast)->create(['sort' => 1]);

        new UpdateOption()->handle($option, ['most_code' => 'D', 'least_code' => 'I']);
        $this->assertSame(['most' => ['D' => 1], 'least' => ['I' => 1]], $option->fresh()->scores);

        $choice = Question::factory()->for($this->assessment)->create(['sort' => 2]);
        $scored = Option::factory()->for($choice)->create(['sort' => 1]);

        new UpdateOption()->handle($scored, ['scores' => ['D' => '2', 'I' => 1]]);
        $this->assertSame(['D' => 2, 'I' => 1], $scored->fresh()->scores);
    }
}
