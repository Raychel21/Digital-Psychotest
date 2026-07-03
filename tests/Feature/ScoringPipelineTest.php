<?php

namespace Tests\Feature;

use App\Enums\NormScale;
use App\Models\Answer;
use App\Models\Assessment;
use App\Models\Attempt;
use App\Models\Dimension;
use App\Models\Option;
use App\Models\Question;
use App\Services\Scoring\NormConverter;
use App\Services\Scoring\RawScoreCalculator;
use App\Services\Scoring\ResultGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScoringPipelineTest extends TestCase
{
    use RefreshDatabase;

    private Assessment $assessment;

    private Dimension $dominance;

    private Dimension $influence;

    private Attempt $attempt;

    protected function setUp(): void
    {
        parent::setUp();

        $this->assessment = Assessment::factory()
            ->published()
            ->primaryScale(NormScale::Change->value)
            ->create();

        $this->dominance = Dimension::factory()->for($this->assessment)->create(['code' => 'D', 'sort' => 1]);
        $this->influence = Dimension::factory()->for($this->assessment)->create(['code' => 'I', 'sort' => 2]);

        $this->attempt = Attempt::factory()->completed()->for($this->assessment)->create();

        foreach ([1, 2] as $sort) {
            $question = Question::factory()->mostLeast()->for($this->assessment)->create(['sort' => $sort]);
            $optionD = Option::factory()->for($question)->mostLeastScores(['D' => 1], ['D' => 1])->create(['sort' => 1]);
            $optionI = Option::factory()->for($question)->mostLeastScores(['I' => 1], ['I' => 1])->create(['sort' => 2]);

            Answer::factory()
                ->for($this->attempt)
                ->for($question)
                ->mostLeast($optionD->id, $optionI->id)
                ->create();
        }
    }

    public function test_raw_score_calculator_computes_most_least_and_change_scales(): void
    {
        $rawScores = new RawScoreCalculator()->calculate($this->attempt);

        $this->assertSame([
            'most' => ['D' => 2, 'I' => 0],
            'least' => ['D' => 0, 'I' => 2],
            'change' => ['D' => 2, 'I' => -2],
        ], $rawScores);
    }

    public function test_norm_converter_maps_matching_rows_and_passes_through_unmatched_scores(): void
    {
        $this->dominance->norms()->create(['scale' => NormScale::Change, 'raw_min' => 1, 'raw_max' => 3, 'value' => 4]);
        $this->dominance->norms()->create(['scale' => NormScale::Most, 'raw_min' => 2, 'raw_max' => 3, 'value' => -4]);

        $rawScores = new RawScoreCalculator()->calculate($this->attempt);
        $normScores = new NormConverter()->convert($this->assessment, $rawScores);

        $this->assertSame([
            'most' => ['D' => -4, 'I' => 0],
            'least' => ['D' => 0, 'I' => 2],
            'change' => ['D' => 4, 'I' => -2],
        ], $normScores);
    }

    public function test_result_generator_persists_result_with_primary_dimension_and_interpretation(): void
    {
        $this->dominance->norms()->create(['scale' => NormScale::Change, 'raw_min' => 1, 'raw_max' => 3, 'value' => 4]);

        $this->assessment->interpretations()->create([
            'dimension_id' => $this->dominance->id,
            'scale' => NormScale::Change,
            'min_value' => 1,
            'max_value' => 8,
            'title' => 'Tipe Dominan',
            'body' => 'Berorientasi pada hasil.',
        ]);
        $this->assessment->interpretations()->create([
            'dimension_id' => $this->influence->id,
            'scale' => NormScale::Change,
            'min_value' => 1,
            'max_value' => 8,
            'title' => 'Tipe Influence',
            'body' => 'Tidak boleh cocok karena skor change I negatif.',
        ]);

        $result = app(ResultGenerator::class)->generate($this->attempt);

        $this->assertDatabaseHas('test_results', ['attempt_id' => $this->attempt->id]);
        $this->assertSame(['D' => 2, 'I' => -2], $result->raw_scores['change']);
        $this->assertSame(['D' => 4, 'I' => -2], $result->norm_scores['change']);
        $this->assertSame('change', $result->summary['primary_scale']);
        $this->assertSame('D', $result->summary['primary_dimension']);
        $this->assertSame([
            ['dimension' => 'D', 'title' => 'Tipe Dominan', 'body' => 'Berorientasi pada hasil.'],
        ], $result->summary['interpretations']);
    }
}
