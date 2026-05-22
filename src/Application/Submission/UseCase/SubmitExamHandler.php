<?php

namespace Testcenter\Application\Submission\UseCase;

use InvalidArgumentException;
use Testcenter\Application\Submission\SubmissionResponse;
use Testcenter\Domain\Exam\ExamRepository;
use Testcenter\Domain\Exam\Exception\ExamNotFoundException;
use Testcenter\Domain\Question\Question;
use Testcenter\Domain\Question\QuestionRepository;
use Testcenter\Domain\Shared\DomainEventPublisher;
use Testcenter\Domain\Submission\Service\ScoringService;
use Testcenter\Domain\Submission\Submission;
use Testcenter\Domain\Submission\SubmissionRepository;

class SubmitExamHandler
{
    public function __construct(
        private readonly ExamRepository $examRepository,
        private readonly QuestionRepository $questionRepository,
        private readonly SubmissionRepository $submissionRepository,
        private readonly ScoringService $scoringService,
        private readonly DomainEventPublisher $publisher,
    ) {
    }

    /**
     * @throws ExamNotFoundException
     */
    public function handle(SubmitExamCommand $command): SubmissionResponse
    {
        $exam = $this->examRepository->findById($command->examId);
        if (!$exam->isActive()) {
            throw new InvalidArgumentException('Exam is not active');
        }

        $questions = $this->questionRepository->findByIds(array_keys($command->answers));
        $answers = $this->makeAnswers($questions, $command->answers);

        $submission = Submission::submit(
            userId: $command->userId,
            examId: $command->examId,
            answers: $answers,
        );

        $scoreResult = $this->scoringService->score($submission, $questions);

        $this->submissionRepository->save($submission, $scoreResult);

        $this->publisher->publish(...$submission->releaseEvents());

        return new SubmissionResponse(
            score: $scoreResult->total(),
        );
    }

    private function makeAnswers(array $questions, array $userAnswers): array
    {
        $result = [];
        foreach ($userAnswers as $questionId => $userAnswer) {
            /** @var Question $question */
            $question = $questions[$questionId] ?? null;
            if (!$question) {
                throw new InvalidArgumentException("Question with ID $questionId not found");
            }

            $result[$questionId] = $question->createAnswer($userAnswer);
        }

        return $result;
    }
}
