<?php

namespace Testcenter\Domain\Question;

class QuestionID
{
    public function __construct(
        private readonly int $id
    ) {
    }

    public function value(): int
    {
        return $this->id;
    }
}