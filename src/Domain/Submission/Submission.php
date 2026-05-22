<?php

namespace Testcenter\Domain\Submission;

use Testcenter\Domain\Exam\ExamID;
use Testcenter\Domain\Shared\AggregateRoot;
use Testcenter\Domain\Submission\Answer\AnswerCollection;
use Testcenter\Domain\User\UserID;

class Submission extends AggregateRoot
{
    public function __construct(
        private readonly UserID $userId,
        private readonly ExamID $examId,
        private readonly AnswerCollection $answers
    ) {
    }

    public function getUserId(): UserID
    {
        return $this->userId;
    }

    public function getExamId(): ExamID
    {
        return $this->examId;
    }

    public function getAnswers(): AnswerCollection
    {
        return $this->answers;
    }

    public static function submit(
        int $userId,
        int $examId,
        array $answers
    ): self {
        $submission = new self(
            userId: new UserID($userId),
            examId: new ExamID($examId),
            answers: new AnswerCollection($answers)
        );

        $submission->recordEvent(new Event\ExamSubmitted($submission));

        return $submission;
    }
}
