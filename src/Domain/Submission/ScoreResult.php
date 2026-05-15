<?php

namespace Testcenter\Domain\Submission;

class ScoreResult
{
    public function __construct(
        public readonly float $total,
        public readonly array $answerScores,
    ) {
    }

    public function total(): float
    {
        return $this->total;
    }
}