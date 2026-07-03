<?php

namespace App\Services\Scoring;

/**
 * Menampung poin per skala dan kode dimensi selama kalkulasi.
 */
class ScoreAccumulator
{
    /** @var array<string, array<string, int>> */
    private array $buckets = [];

    /**
     * @param  list<string>  $dimensionCodes
     */
    public function __construct(private readonly array $dimensionCodes) {}

    public function add(string $scale, string $dimensionCode, int $points): void
    {
        if (! in_array($dimensionCode, $this->dimensionCodes, true)) {
            return;
        }

        $this->ensureScale($scale);
        $this->buckets[$scale][$dimensionCode] += $points;
    }

    public function hasScale(string $scale): bool
    {
        return isset($this->buckets[$scale]);
    }

    /**
     * @return array<string, array<string, int>>
     */
    public function toArray(): array
    {
        return $this->buckets;
    }

    private function ensureScale(string $scale): void
    {
        if (! isset($this->buckets[$scale])) {
            $this->buckets[$scale] = array_fill_keys($this->dimensionCodes, 0);
        }
    }
}
