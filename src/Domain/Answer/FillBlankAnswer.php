<?php

namespace Testcenter\Domain\Answer;

final class FillBlankAnswer implements Answer
{
    public function __construct(
        private readonly string $value
    ) {}

    public function value(): string
    {
        return $this->value;
    }
}