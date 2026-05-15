<?php

namespace Testcenter\Domain\Question;

use Testcenter\Domain\Question\Exception\QuestionNotFoundException;

interface QuestionRepository
{
    /** @return array<Question> */
    public function findByIds(array $ids): array;

    /**
     * @throws QuestionNotFoundException
     */
    public function findById(int $id): Question;
}