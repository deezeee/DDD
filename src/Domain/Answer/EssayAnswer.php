<?php

namespace Testcenter\Domain\Answer;

final class EssayAnswer implements Answer
{
    public function __construct(
        private readonly string $content
    ) {}

    public function value(): string
    {
        return $this->content;
    }
}