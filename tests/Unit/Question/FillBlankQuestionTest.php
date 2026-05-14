<?php

namespace Tests\Unit\Question;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Testcenter\Domain\Answer\FillBlankAnswer;
use Testcenter\Domain\Answer\TrueFalseAnswer;
use Testcenter\Domain\Question\AcceptedAnswers;
use Testcenter\Domain\Question\QuestionID;
use Testcenter\Domain\Question\QuestionText;
use Testcenter\Domain\Question\QuestionType;
use Testcenter\Domain\Question\Type\FillBlankQuestion;
use Testcenter\Domain\Score;

class FillBlankQuestionTest extends TestCase
{
    public function test_it_returns_full_score_when_answer_is_correct(): void
    {
        $question = new FillBlankQuestion(
            id: new QuestionID(1),
            type: QuestionType::FILL_BLANK,
            text: new QuestionText('What is the capital of Vietnam?'),
            score: new Score(5.0),
            acceptedAnswers: new AcceptedAnswers([
                'Hanoi',
                'Ha Noi',
            ]),
        );

        $result = $question->grade(
            new FillBlankAnswer('Hanoi')
        );

        $this->assertTrue($result->isCorrect());
        $this->assertEquals(5.0, $result->score()->value());
    }

    public function test_it_returns_zero_score_when_answer_is_incorrect(): void
    {
        $question = new FillBlankQuestion(
            id: new QuestionID(1),
            type: QuestionType::FILL_BLANK,
            text: new QuestionText('What is the capital of Vietnam?'),
            score: new Score(10),
            acceptedAnswers: new AcceptedAnswers([
                'Hanoi',
                'Ha Noi',
            ]),
        );

        $result = $question->grade(
            new FillBlankAnswer('Tokyo')
        );

        $this->assertFalse($result->isCorrect());
        $this->assertEquals(0, $result->score()->value());
    }

    public function test_it_throws_exception_when_answer_type_is_invalid(): void
    {
        $question = new FillBlankQuestion(
            id: new QuestionID(1),
            type: QuestionType::FILL_BLANK,
            text: new QuestionText('What is the capital of Vietnam?'),
            score: new Score(10),
            acceptedAnswers: new AcceptedAnswers([
                'Hanoi',
            ]),
        );

        $this->expectException(
            InvalidArgumentException::class
        );

        $question->grade(new TrueFalseAnswer(true));
    }
}