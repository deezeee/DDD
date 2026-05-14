<?php

namespace Testcenter\Domain\Answer;

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