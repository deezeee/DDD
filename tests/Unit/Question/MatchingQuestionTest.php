<?php

namespace Tests\Unit\Question;

use PHPUnit\Framework\TestCase;
use Testcenter\Domain\Question\MatchingPairs;
use Testcenter\Domain\Question\QuestionID;
use Testcenter\Domain\Question\QuestionText;
use Testcenter\Domain\Question\QuestionType;
use Testcenter\Domain\Question\Type\MatchingQuestion;
use Testcenter\Domain\Score;
use Testcenter\Domain\Submission\Answer\MatchingAnswer;
use Testcenter\Domain\Submission\Answer\TrueFalseAnswer;

class MatchingQuestionTest extends TestCase
{
    public function test_it_returns_full_score_when_all_pairs_are_correct(): void
    {
        $question = new MatchingQuestion(
            id: new QuestionID(1),
            text: new QuestionText('Match countries with capitals'),
            score: new Score(5.0),
            pairs: new MatchingPairs([
                'Vietnam' => 'Hanoi',
                'Japan' => 'Tokyo',
            ]),
        );

        $result = $question->grade(
            new MatchingAnswer([
                'Vietnam' => 'Hanoi',
                'Japan' => 'Tokyo',
            ])
        );


        $this->assertTrue($result->isCorrect());
        $this->assertEquals(5.0, $result->score()->value());
    }

    public function test_it_returns_zero_score_when_all_pairs_are_wrong(): void
    {
        $question = new MatchingQuestion(
            id: new QuestionID(1),
            text: new QuestionText('Match countries with capitals'),
            score: new Score(10),
            pairs: new MatchingPairs([
                'Vietnam' => 'Hanoi',
                'Japan' => 'Tokyo',
            ]),
        );

        $result = $question->grade(
            new MatchingAnswer([
                'Vietnam' => 'Tokyo',
                'Japan' => 'Hanoi',
            ])
        );

        $this->assertFalse($result->isCorrect());
        $this->assertEquals(0, $result->score()->value());
    }

    public function test_it_returns_false_when_less_than_half_are_correct(): void
    {
        $question = new MatchingQuestion(
            id: new QuestionID(1),
            text: new QuestionText('Match countries with capitals'),
            score: new Score(10.0),
            pairs: new MatchingPairs([
                'Vietnam' => 'Hanoi',
                'Japan' => 'Tokyo',
                'Korea' => 'Seoul',
                'France' => 'Paris',
            ]),
        );

        $result = $question->grade(
            new MatchingAnswer([
                'Vietnam' => 'Hanoi',
                'Japan' => 'Seoul',
                'Korea' => 'Paris',
                'France' => 'Tokyo',
            ])
        );

        $this->assertFalse($result->IsCorrect());
        $this->assertEquals(2.5, $result->score()->value());
    }

    public function test_it_throws_exception_when_answer_type_is_invalid(): void
    {
        $question = new MatchingQuestion(
            id: new QuestionID(1),
            text: new QuestionText('Match countries with capitals'),
            score: new Score(10),
            pairs: new MatchingPairs([
                'Vietnam' => 'Hanoi',
            ]),
        );

        $this->expectException(
            \InvalidArgumentException::class
        );

        $question->grade(new TrueFalseAnswer(true));
    }
}