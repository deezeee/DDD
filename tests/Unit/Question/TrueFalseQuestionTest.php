<?php

namespace Tests\Unit\Question;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Testcenter\Domain\Answer\FillBlankAnswer;
use Testcenter\Domain\Answer\TrueFalseAnswer;
use Testcenter\Domain\Question\QuestionID;
use Testcenter\Domain\Question\QuestionText;
use Testcenter\Domain\Question\QuestionType;
use Testcenter\Domain\Question\Type\TrueFalseQuestion;
use Testcenter\Domain\Score;

class TrueFalseQuestionTest extends TestCase
{
    public function test_it_returns_full_score_when_answer_is_correct(): void
    {
        $question = new TrueFalseQuestion(
            id: new QuestionID(1),
            type: QuestionType::TRUE_FALSE,
            text: new QuestionText('PHP is a programming language'),
            score: new Score(3.0),
            correct: true,
        );

        $result = $question->grade(
            new TrueFalseAnswer(true)
        );

        $this->assertTrue($result->isCorrect());
        $this->assertEquals(3.0, $result->score()->value());
    }

    public function test_it_returns_zero_score_when_answer_is_wrong(): void
    {
        $question = new TrueFalseQuestion(
            id: new QuestionID(1),
            type: QuestionType::TRUE_FALSE,
            text: new QuestionText('PHP is a programming language'),
            score: new Score(10),
            correct: true,
        );

        $result = $question->grade(
            new TrueFalseAnswer(false)
        );

        $this->assertFalse($result->isCorrect());
        $this->assertEquals(0, $result->score()->value());
    }

    public function test_it_throws_exception_when_answer_type_is_invalid(): void
    {
        $question = new TrueFalseQuestion(
            id: new QuestionID(1),
            type: QuestionType::TRUE_FALSE,
            text: new QuestionText('PHP is a programming language'),
            score: new Score(10),
            correct: true,
        );

        $this->expectException(
            InvalidArgumentException::class
        );

        $question->grade(
            new FillBlankAnswer('PHP')
        );
    }
}