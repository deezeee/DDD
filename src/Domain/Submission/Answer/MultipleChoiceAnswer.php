<?php

namespace Testcenter\Domain\Submission\Answer;

use Testcenter\Domain\Submission\Exception\SubmissionException;

class MultipleChoiceAnswer implements Answer
{
    /**
     * @param string[] $choices
     * @throws SubmissionException
     */
    public function __construct(
        private readonly array $choices,
    ) {
        $this->ensureNotEmpty($choices);
        $this->ensureNoDuplicate($choices);
    }

    public function choices(): array
    {
        return $this->choices;
    }

    /**
     * @throws SubmissionException
     */
    private function ensureNotEmpty(array $choices): void
    {
        if ($choices === []) {
            throw new SubmissionException('Multiple choice answer cannot be empty');
        }
    }

    /**
     * @throws SubmissionException
     */
    private function ensureNoDuplicate(array $choices): void
    {
        if (count($choices) !== count(array_unique($choices))) {
            throw new SubmissionException('Duplicate choices are not allowed');
        }
    }

    public function value(): array
    {
        return $this->choices;
    }
}
