<?php

namespace Testcenter\Application\Submission\UseCase;

use Testcenter\Application\Submission\SubmissionResponse;
use Testcenter\Domain\AppException;
use Testcenter\Domain\Exam\ExamRepository;
use Testcenter\Domain\Question\Question;
use Testcenter\Domain\Question\QuestionCollection;
use Testcenter\Domain\Question\QuestionID;
use Testcenter\Domain\Question\QuestionRepository;
use Testcenter\Domain\Shared\DomainEventPublisher;
use Testcenter\Domain\Submission\Exception\SubmissionException;
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
     * @throws AppException
     */
    public function handle(SubmitExamCommand $command): SubmissionResponse
    {
        $exam = $this->examRepository->findById($command->examId);
        $questions = $this->questionRepository->findQuestionsForExam(array_keys($command->answers));
        $answers = $this->makeAnswers($questions, $command->answers);

        $submission = Submission::submit(
            userId: $command->userId,
            exam: $exam,
            answers: $answers,
        );

        $scoreResult = $this->scoringService->score($submission, $questions);
        $submission->applyScore($scoreResult);
        $this->submissionRepository->save($submission);

        $this->publisher->publish(...$submission->releaseEvents());

        return new SubmissionResponse(
            score: $scoreResult->total(),
        );
    }

    /**
     * @throws SubmissionException
     */
    private function makeAnswers(QuestionCollection $questions, array $userAnswers): array
    {
        $result = [];
        foreach ($userAnswers as $questionId => $userAnswer) {
            /** @var Question $question */
            $question = $questions->findById(new QuestionID($questionId));
            if (!$question) {
                throw new SubmissionException("Question with ID $questionId not found");
            }

            $result[$questionId] = $question->createAnswer($userAnswer);
        }

        return $result;
    }
}
