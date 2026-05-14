<?php

namespace Testcenter\Domain\Exam;

class Title
{
    public function __construct(
        private readonly string $title
    ) {
        if (empty(trim($title))) {
            throw new \InvalidArgumentException(
                'Exam title cannot be empty'
            );
        }
    }

    public function value(): string
    {
        return $this->title;
    }
}