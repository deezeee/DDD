<?php

namespace Testcenter\Domain\Exam;

class ExamID
{
    public function __construct(
        private readonly int $id
    ) {
        if (empty($id)) {
            throw new \InvalidArgumentException(
                'Exam ID cannot be empty'
            );
        }
    }

    public function value(): int
    {
        return $this->id;
    }
}