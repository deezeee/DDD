<?php

namespace Testcenter\Domain\Question\Pair;

use InvalidArgumentException;

class MatchingPair
{
    public function __construct(
        private readonly string $left,
        private readonly string $right,
    ) {
        $this->ensureValid();
    }

    public function left(): string
    {
        return $this->left;
    }

    public function right(): string
    {
        return $this->right;
    }

    private function ensureValid(): void
    {
        if (trim($this->left) === '') {
            throw new InvalidArgumentException('Left value cannot be empty');
        }

        if (trim($this->right) === '') {
            throw new InvalidArgumentException('Right value cannot be empty');
        }
    }
}