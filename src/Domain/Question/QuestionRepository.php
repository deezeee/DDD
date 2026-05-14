<?php

namespace Testcenter\Domain\Question;

interface QuestionRepository
{
    /** @return array<Question> */
    public function findByExamId(int $examId): array;
}