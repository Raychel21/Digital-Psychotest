<?php

namespace Tests\Feature;

use App\Enums\AssessmentStatus;
use App\Enums\NormScale;
use App\Enums\QuestionType;
use App\Models\Assessment;
use App\Models\Norm;
use App\Models\Option;
use Database\Seeders\DiscAssessmentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiscSeederTest extends TestCase
{
    use RefreshDatabase;

    private Assessment $assessment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DiscAssessmentSeeder::class);

        $this->assessment = Assessment::query()->where('slug', 'disc')->firstOrFail();
    }

    public function test_assessment_is_published_with_change_as_primary_scale(): void
    {
        $this->assertSame('Tes Kepribadian DISC', $this->assessment->name);
        $this->assertSame(AssessmentStatus::Published, $this->assessment->status);
        $this->assertSame('change', $this->assessment->primaryScale());
        $this->assertNotEmpty($this->assessment->instructions);
    }

    public function test_four_disc_dimensions_are_seeded_in_order(): void
    {
        $dimensions = $this->assessment->dimensions;

        $this->assertSame(4, $dimensions->count());
        $this->assertSame(['D', 'I', 'S', 'C'], $dimensions->pluck('code')->all());
        $this->assertSame(
            ['Dominance', 'Influence', 'Steadiness', 'Conscientiousness'],
            $dimensions->pluck('name')->all(),
        );
    }

    public function test_twenty_four_most_least_questions_with_four_options_each_are_seeded(): void
    {
        $questions = $this->assessment->questions()->with('options')->get();

        $this->assertSame(24, $questions->count());
        $this->assertSame(96, Option::query()->count());
        $this->assertSame(range(1, 24), $questions->pluck('sort')->all());

        foreach ($questions as $question) {
            $this->assertSame(QuestionType::MostLeast, $question->type);
            $this->assertCount(4, $question->options);

            foreach ($question->options as $option) {
                $this->assertSame(['most', 'least'], array_keys($option->scores));
                $this->assertSame([1], array_values($option->scores['most']));
                $this->assertSame([1], array_values($option->scores['least']));
            }
        }
    }

    public function test_first_question_options_carry_the_legacy_statements_and_letters(): void
    {
        $options = $this->assessment->questions()->orderBy('sort')->firstOrFail()->options;

        $this->assertSame(
            [
                'Mudah bergaul, ramah',
                'Penuh kepercayaan, Percaya kepada orang lain',
                'Petualang, pengambil risiko',
                'Toleran, Penuh hormat',
            ],
            $options->pluck('label')->all(),
        );
        $this->assertSame(['most' => ['N' => 1], 'least' => ['D' => 1]], $options[2]->scores);
    }

    public function test_norm_rows_match_the_legacy_mapping_tables(): void
    {
        $this->assertSame(77, Norm::query()->count());

        $dimensions = $this->assessment->dimensions->keyBy('code');

        $this->assertSame(9, $dimensions['D']->norms()->where('scale', NormScale::Most)->count());
        $this->assertSame(9, $dimensions['D']->norms()->where('scale', NormScale::Least)->count());
        $this->assertSame(0, $dimensions['I']->norms()->where('scale', NormScale::Least)->count());
        $this->assertSame(8, $dimensions['C']->norms()->where('scale', NormScale::Change)->count());

        $this->assertSame(4, $this->normValueFor($dimensions['D']->id, NormScale::Most, 11));
        $this->assertSame(7, $this->normValueFor($dimensions['I']->id, NormScale::Most, 13));
        $this->assertSame(-8, $this->normValueFor($dimensions['D']->id, NormScale::Least, 18));
        $this->assertSame(6, $this->normValueFor($dimensions['S']->id, NormScale::Change, 5));
        $this->assertSame(-6, $this->normValueFor($dimensions['C']->id, NormScale::Change, -12));
    }

    public function test_interpretations_cover_all_dimensions_on_the_change_scale(): void
    {
        $interpretations = $this->assessment->interpretations()->with('dimension')->get();

        $this->assertSame(4, $interpretations->count());

        foreach ($interpretations as $interpretation) {
            $this->assertSame(NormScale::Change, $interpretation->scale);
            $this->assertSame(1, $interpretation->min_value);
            $this->assertSame(8, $interpretation->max_value);
        }

        $titles = $interpretations->keyBy(fn ($interpretation): string => $interpretation->dimension->code);
        $this->assertSame('Dominance (Dominan, Tegas, Pengambil Risiko)', $titles['D']->title);
        $this->assertStringContainsString('Suka bersosialisasi', $titles['I']->body);
    }

    public function test_seeder_is_idempotent(): void
    {
        $this->seed(DiscAssessmentSeeder::class);

        $this->assertSame(1, Assessment::query()->count());
        $this->assertSame(24, $this->assessment->questions()->count());
        $this->assertSame(96, Option::query()->count());
        $this->assertSame(77, Norm::query()->count());
    }

    private function normValueFor(int $dimensionId, NormScale $scale, int $raw): ?int
    {
        return Norm::query()
            ->where('dimension_id', $dimensionId)
            ->where('scale', $scale)
            ->where('raw_min', '<=', $raw)
            ->where('raw_max', '>=', $raw)
            ->value('value');
    }
}
