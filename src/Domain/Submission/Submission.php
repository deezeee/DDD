<?php

namespace Testcenter\Domain\Submission;

use Testcenter\Domain\Exam\Exam;
use Testcenter\Domain\Exam\ExamID;
use Testcenter\Domain\Exam\Exception\ExamNotActiveException;
use Testcenter\Domain\Shared\AggregateRoot;
use Testcenter\Domain\Submission\Answer\AnswerCollection;
use Testcenter\Domain\User\UserID;

class Submission extends AggregateRoot
{
    private ScoreResult $scoreResult;

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

    /**
     * @throws ExamNotActiveException
     */
    public static function submit(
        int $userId,
        Exam $exam,
        array $answers
    ): self {
        if (!$exam->isActive()) {
            throw new ExamNotActiveException('Exam is not active');
        }

        $submission = new self(
            userId: new UserID($userId),
            examId: $exam->id(),
            answers: new AnswerCollection($answers)
        );

        $submission->recordEvent(new Event\ExamSubmitted($submission));

        return $submission;
    }

    public function applyScore($scoreResult): void
    {
        $this->scoreResult = $scoreResult;
    }

    public function getScoreResult(): ScoreResult
    {
        return $this->scoreResult;
    }
}
