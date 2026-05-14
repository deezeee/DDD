<?php

namespace Testcenter\Domain\Submission;

use Testcenter\Domain\Score;

class Submission
{
    public function __construct(
        private readonly int $userId,
        private readonly int $examId,
        private readonly Score $score,
        private readonly array $answers
    ) {
    }
}