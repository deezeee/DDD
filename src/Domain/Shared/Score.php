<?php

namespace Testcenter\Domain\Shared;

use InvalidArgumentException;

class Score
{
    public function __construct(
        private readonly float $value,
    ) {
        $this->ensureValid($value);
    }

    private function ensureValid(float $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Score cannot be negative');
        }
    }

    public function value(): float
    {
        return $this->value;
    }
}