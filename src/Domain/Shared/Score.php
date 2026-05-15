<?php

namespace Testcenter\Domain\Shared;

class Score
{
    public function __construct(
        private readonly float $value
    ) {
        if ($value < 0) {
            throw new \InvalidArgumentException(
                'Score must be >= 0'
            );
        }
    }

    public function value(): float
    {
        return $this->value;
    }
}