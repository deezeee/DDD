<?php

namespace Testcenter\Application\Submission\UseCase;

use InvalidArgumentException;
use Testcenter\Domain\Question\Question;
use Testcenter\Domain\Question\QuestionRepository;
use Testcenter\Domain\Question\QuestionType;
use Testcenter\Domain\Score;
use Testcenter\Domain\Submission\Answer\Answer;
use Testcenter\Domain\Submission\Answer\FillBlankAnswer;
use Testcenter\Domain\Submission\Answer\MatchingAnswer;
use Testcenter\Domain\Submission\Answer\SingleChoiceAnswer;
use Testcenter\Domain\Submission\Answer\TrueFalseAnswer;
use Testcenter\Domain\Submission\Event\JustHasNewSubmission;
use Testcenter\Domain\Submission\Submission;
use Testcenter\Domain\Submission\SubmissionRepository;

class SubmitExamHandler
{
    public function __construct(
        private readonly QuestionRepository $questionRepository,
        private readonly SubmissionRepository $submissionRepository,
    ) {
    }

    public function handle(SubmitExamCommand $command): array
    {
        $questions = $this->questionRepository->findByIds(array_keys($command->answers));
        $answers = $this->makeAnswers($questions, $command->answers);
        $submission = new Submission(
            userId: $command->userId,
            examId: $command->examId,
            questions: $questions,
            answers: $answers,
        );

        $scoreResult = $submission->score();

        $this->submissionRepository->save($submission);

        event(new JustHasNewSubmission($submission));

        return [
            'exam_id' => $command->examId,
            'user_id' => $command->userId,
            'score' => $scoreResult->total(),
        ];
    }

    private function score(array $questions, array $answers): float
    {
        $totalScore = 0;
        /** @var Question $question */
        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id()->value()] ?? null;
            $score = $question->grade($userAnswer);

            $totalScore += $score->score()->value();
        }

        return $totalScore;
    }

    private function makeAnswers(array $questions, array $userAnswers): array
    {
        $result = [];
        foreach ($userAnswers as $questionId => $userAnswer) {
            $result[$questionId] = $this->buildAnswer(
                question: $questions[$questionId],
                userAnswer: $userAnswer,
            );
        }

        return $result;
    }

    private function buildAnswer(Question $question, mixed $userAnswer): Answer
    {
        return match ($question->type()) {
            QuestionType::TRUE_FALSE => new TrueFalseAnswer($userAnswer),
            QuestionType::SINGLE_CHOICE => new SingleChoiceAnswer($userAnswer),
            QuestionType::FILL_BLANK => new FillBlankAnswer($userAnswer),
            QuestionType::MATCHING => new MatchingAnswer($userAnswer),
            default => throw new InvalidArgumentException('Unsupported question type'),
        };
    }
}