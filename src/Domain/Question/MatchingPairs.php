<?php

namespace Testcenter\Domain\Question;

class MatchingPairs
{
    public function __construct(
        public readonly array $pairs
    ) {
        if (empty($pairs)) {
            throw new \InvalidArgumentException(
                'Matching pairs cannot be empty'
            );
        }
    }

    public function total(): int
    {
        return count($this->pairs);
    }

    public function isCorrect(string $left, string $right): bool
    {
        return isset($this->pairs[$left]) && $this->pairs[$left] === $right;
    }
}