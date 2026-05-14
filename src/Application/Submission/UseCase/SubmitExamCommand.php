<?php

namespace Testcenter\Application\Submission\UseCase;

class SubmitExamCommand
{
    public function __construct(
        public int $examId,
        public int $userId,
        public array $answers
    ) {}
}