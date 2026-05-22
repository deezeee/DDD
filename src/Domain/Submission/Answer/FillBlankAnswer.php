<?php

namespace Testcenter\Domain\Submission\Answer;

use Testcenter\Domain\Submission\Exception\SubmissionException;

final class FillBlankAnswer implements Answer
{
    /**
     * @throws SubmissionException
     */
    public function __construct(
        private readonly string $value,
    ) {
        $this->ensureNotEmpty($value);
    }

    /**
     * @throws SubmissionException
     */
    private function ensureNotEmpty(string $value): void
    {
        if (trim($value) === '') {
            throw new SubmissionException('Fill blank answer cannot be empty');;
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}