<?php

namespace App\Actions\Builder;

use App\Models\Assessment;

/**
 * Simpan variabel & rumus kustom assessment ke kolom `assessments.logic`.
 *
 * Bentuk simpanan: {"variables": [{"name", "formula", "workspace"}, ...]}.
 * LogicEvaluator hanya membaca `name` + `formula`; `workspace` dipakai untuk
 * merender ulang blok Blockly saat editor dibuka kembali.
 */
class SaveAssessmentVariables
{
    /**
     * @param  list<array{name?: mixed, formula?: mixed, workspace?: mixed}>  $variables
     */
    public function handle(Assessment $assessment, array $variables): Assessment
    {
        $clean = [];

        foreach ($variables as $variable) {
            $name = trim((string) ($variable['name'] ?? ''));

            if ($name === '') {
                continue;
            }

            $clean[] = [
                'name' => $name,
                'formula' => $variable['formula'] ?? null,
                'workspace' => is_array($variable['workspace'] ?? null) ? $variable['workspace'] : null,
            ];
        }

        $logic = $assessment->logic ?? [];

        if ($clean === []) {
            unset($logic['variables']);
        } else {
            $logic['variables'] = $clean;
        }

        $assessment->update(['logic' => $logic === [] ? null : $logic]);

        return $assessment;
    }
}
