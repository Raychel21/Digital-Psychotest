<?php

namespace Database\Seeders;

use App\Enums\AssessmentStatus;
use App\Enums\NormScale;
use App\Enums\QuestionType;
use App\Models\Assessment;
use App\Models\Dimension;
use Illuminate\Database\Seeder;

class DiscAssessmentSeeder extends Seeder
{
    private const string INSTRUCTIONS = <<<'TEXT'
        Anda akan diberikan 24 kelompok pernyataan. Setiap kelompok terdiri dari 4 pernyataan.

        Tugas Anda adalah memilih:
        - Satu pernyataan yang PALING (M) menggambarkan diri Anda di lingkungan kerja.
        - Satu pernyataan yang KURANG (L) menggambarkan diri Anda di lingkungan kerja.

        Perhatian: Kerjakanlah secara spontan dan jujur. Pilihan pertama Anda biasanya adalah yang paling akurat. Tidak ada jawaban benar atau salah dalam tes ini.
        TEXT;

    /** @var array<string, array{0: string, 1: string, 2: int}> */
    private const array DIMENSIONS = [
        'D' => ['Dominance', 'Dominan, Tegas, Pengambil Risiko', 1],
        'I' => ['Influence', 'Berpengaruh, Antusias, Ramah', 2],
        'S' => ['Steadiness', 'Stabil, Sabar, Pendengar Baik', 3],
        'C' => ['Conscientiousness', 'Teliti, Analitis, Taat Aturan', 4],
    ];

    public function run(): void
    {
        $assessment = Assessment::query()->updateOrCreate(
            ['slug' => 'disc'],
            [
                'name' => 'Tes Kepribadian DISC',
                'description' => 'Tes kepribadian DISC (Dominance, Influence, Steadiness, Conscientiousness) dengan format forced-choice most/least.',
                'instructions' => self::INSTRUCTIONS,
                'status' => AssessmentStatus::Published,
                'settings' => ['primary_scale' => NormScale::Change->value],
            ],
        );

        $assessment->questions()->delete();
        $assessment->dimensions()->delete();

        $dimensions = $this->seedDimensions($assessment);
        $this->seedQuestions($assessment);
        $this->seedNorms($dimensions);
        $this->seedInterpretations($assessment, $dimensions);
    }

    /**
     * @return array<string, Dimension>
     */
    private function seedDimensions(Assessment $assessment): array
    {
        $dimensions = [];

        foreach (self::DIMENSIONS as $code => [$name, $description, $sort]) {
            $dimensions[$code] = $assessment->dimensions()->create([
                'code' => $code,
                'name' => $name,
                'description' => $description,
                'sort' => $sort,
            ]);
        }

        return $dimensions;
    }

    private function seedQuestions(Assessment $assessment): void
    {
        /** @var array<int, list<array{0: string, 1: string, 2: string}>> $questions */
        $questions = require __DIR__.'/data/disc_questions.php';

        foreach ($questions as $nomor => $statements) {
            $question = $assessment->questions()->create([
                'type' => QuestionType::MostLeast,
                'text' => "Kelompok pernyataan {$nomor}",
                'sort' => $nomor,
                'required' => true,
            ]);

            foreach ($statements as $index => [$statement, $most, $least]) {
                $question->options()->create([
                    'label' => $statement,
                    'sort' => $index + 1,
                    'scores' => [
                        'most' => [$most => 1],
                        'least' => [$least => 1],
                    ],
                ]);
            }
        }
    }

    /**
     * @param  array<string, Dimension>  $dimensions
     */
    private function seedNorms(array $dimensions): void
    {
        /** @var array{most: array<string, list<array{0: int, 1: int, 2: int}>>, least: array<string, list<array{0: int, 1: int, 2: int}>>, change: list<array{0: int, 1: int, 2: int}>} $norms */
        $norms = require __DIR__.'/data/disc_norms.php';

        foreach ([NormScale::Most, NormScale::Least] as $scale) {
            foreach ($norms[$scale->value] as $code => $ranges) {
                $this->createNormRows($dimensions[$code], $scale, $ranges);
            }
        }

        foreach ($dimensions as $dimension) {
            $this->createNormRows($dimension, NormScale::Change, $norms['change']);
        }
    }

    /**
     * @param  list<array{0: int, 1: int, 2: int}>  $ranges
     */
    private function createNormRows(Dimension $dimension, NormScale $scale, array $ranges): void
    {
        foreach ($ranges as [$rawMin, $rawMax, $value]) {
            $dimension->norms()->create([
                'scale' => $scale,
                'raw_min' => $rawMin,
                'raw_max' => $rawMax,
                'value' => $value,
            ]);
        }
    }

    /**
     * @param  array<string, Dimension>  $dimensions
     */
    private function seedInterpretations(Assessment $assessment, array $dimensions): void
    {
        /** @var array<string, array{0: string, 1: string}> $interpretations */
        $interpretations = require __DIR__.'/data/disc_interpretations.php';

        foreach ($interpretations as $code => [$title, $body]) {
            $assessment->interpretations()->create([
                'dimension_id' => $dimensions[$code]->id,
                'scale' => NormScale::Change,
                'min_value' => 1,
                'max_value' => 8,
                'title' => $title,
                'body' => $body,
            ]);
        }
    }
}
