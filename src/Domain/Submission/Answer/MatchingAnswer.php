<?php

namespace Testcenter\Domain\Submission\Answer;

class MatchingAnswer implements Answer
{
    public function __construct(
        private readonly array $pairs
    ) {
    }

    public function value(): array
    {
        return $this->pairs;
    }
}