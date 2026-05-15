<?php

namespace Testcenter\Infrastructure\Question;

use Testcenter\Domain\Question\AcceptedAnswers;
use Testcenter\Domain\Question\MatchingPairs;
use Testcenter\Domain\Question\OptionCollection;
use Testcenter\Domain\Question\Question;
use Testcenter\Domain\Question\QuestionID;
use Testcenter\Domain\Question\QuestionText;
use Testcenter\Domain\Question\QuestionType;
use Testcenter\Domain\Question\Type\FillBlankQuestion;
use Testcenter\Domain\Question\Type\MatchingQuestion;
use Testcenter\Domain\Question\Type\SingleChoiceQuestion;
use Testcenter\Domain\Question\Type\TrueFalseQuestion;
use Testcenter\Domain\Score;

class QuestionMapper
{
    public function toDomain(\App\Models\Question $questionEloquent): Question
    {
        return match ($questionEloquent->type) {
            'true_false' =>
            new TrueFalseQuestion(
                id: new QuestionID($questionEloquent->id),
                type: QuestionType::TRUE_FALSE,
                text: new QuestionText($questionEloquent->content),
                score: new Score($questionEloquent->score),
                correct: $questionEloquent->payload['correct'],
            ),
            'single_choice' =>
            new SingleChoiceQuestion(
                id: new QuestionID($questionEloquent->id),
                type: QuestionType::SINGLE_CHOICE,
                text: new QuestionText($questionEloquent->content),
                score: new Score($questionEloquent->score),
                options: new OptionCollection($questionEloquent->payload['options']),
                correct: $questionEloquent->payload['correct']
            ),
            'fill_blank' =>
            new FillBlankQuestion(
                id: new QuestionID($questionEloquent->id),
                type: QuestionType::FILL_BLANK,
                text: new QuestionText($questionEloquent->content),
                score: new Score($questionEloquent->score),
                acceptedAnswers: new AcceptedAnswers($questionEloquent->payload['answers']),
            ),
            'matching' =>
            new MatchingQuestion(
                id: new QuestionID($questionEloquent->id),
                type: QuestionType::MATCHING,
                text: new QuestionText($questionEloquent->content),
                score: new Score($questionEloquent->score),
                pairs: new MatchingPairs($questionEloquent->payload['pairs']),
            )
        };
    }
}
