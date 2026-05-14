<?php

namespace Testcenter\Domain\Exam;

use Testcenter\Domain\Exam\Exception\ExamNotFoundException;

interface ExamRepository
{
    /**
     * @throws ExamNotFoundException
     */
    public function findById(int $id): Exam;
}