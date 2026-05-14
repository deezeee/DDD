<?php

namespace Testcenter\Domain\Exam;

class Description
{
    public function __construct(
        private readonly string $description
    ) {
        if (empty(trim($description))) {
            throw new \InvalidArgumentException(
                'Exam description cannot be empty'
            );
        }
    }

    public function value(): string
    {
        return $this->description;
    }
}