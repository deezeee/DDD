<?php

namespace Testcenter\Domain\Question;

class QuestionText
{
    public function __construct(
        private readonly string $text
    ) {
        if (empty(trim($text))) {
            throw new \InvalidArgumentException(
                'Question text cannot be empty'
            );
        }
    }

    public function value(): string
    {
        return $this->text;
    }
}