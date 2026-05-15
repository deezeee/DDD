<?php

namespace Testcenter\Domain\Submission\Answer;

class TrueFalseAnswer implements Answer
{
    public function __construct(
        private readonly bool $value
    ) {
    }

    public function value(): bool
    {
        return $this->value;
    }
}