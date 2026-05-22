<?php

namespace Testcenter\Domain\Submission\Service;

use Testcenter\Domain\Question\Question;
use Testcenter\Domain\Submission\ScoreResult;
use Testcenter\Domain\Submission\Submission;

class ScoringService
{

    public function score(Submission $submission, array $questions): ScoreResult
    {
        $totalScore = 0;
        $answerScores = [];
        /** @var Question $question */
        foreach ($questions as $question) {
            $userAnswer = $submission->getAnswers()->findByQuestionId($question->id());
            $score = $question->grade($userAnswer);
            $answerScores[$question->id()->value()] = $score;
            $totalScore += $score->score()->value();
        }

        return new ScoreResult($totalScore, $answerScores);
    }
}