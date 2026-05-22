<?php

namespace Testcenter\Domain\Question;

use Testcenter\Domain\Question\Exception\QuestionNotFoundException;

interface QuestionRepository
{
    public function findQuestionsForExam(array $ids): QuestionCollection;

    /**
     * @throws QuestionNotFoundException
     */
    public function findById(int $id): Question;
}