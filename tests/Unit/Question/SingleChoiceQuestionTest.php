<?php

namespace Tests\Unit\Question;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Testcenter\Domain\Question\OptionCollection;
use Testcenter\Domain\Question\QuestionID;
use Testcenter\Domain\Question\QuestionText;
use Testcenter\Domain\Question\QuestionType;
use Testcenter\Domain\Question\Type\SingleChoiceQuestion;
use Testcenter\Domain\Score;
use Testcenter\Domain\Submission\Answer\SingleChoiceAnswer;
use Testcenter\Domain\Submission\Answer\TrueFalseAnswer;

class SingleChoiceQuestionTest extends TestCase
{
    public function test_it_returns_full_score_when_answer_is_correct(): void
    {
        $question = new SingleChoiceQuestion(
            id: new QuestionID(1),
            text: new QuestionText('What is the capital of Vietnam?'),
            score: new Score(10.0),
            options: new OptionCollection([
                'A' => 'Hanoi',
                'B' => 'Tokyo',
                'C' => 'Bangkok',
                'D' => 'Seoul',
            ]),
            correct: 'A',
        );

        $result = $question->grade(new SingleChoiceAnswer('A'));

        $this->assertTrue($result->isCorrect());
        $this->assertEquals(10.0, $result->score()->value());
    }

    public function test_it_returns_zero_score_when_answer_is_incorrect(): void
    {
        $question = new SingleChoiceQuestion(
            id: new QuestionID(1),
            text: new QuestionText('What is the capital of Vietnam?'),
            score: new Score(10),
            options: new OptionCollection([
                'A' => 'Hanoi',
                'B' => 'Tokyo',
                'C' => 'Bangkok',
                'D' => 'Seoul',
            ]),
            correct: 'A',
        );

        $result = $question->grade(new SingleChoiceAnswer('B'));

        $this->assertFalse($result->isCorrect());
        $this->assertEquals(0, $result->score()->value());
    }

    public function test_it_returns_options(): void
    {
        $options = new OptionCollection([
            'A' => 'Hanoi',
            'B' => 'Tokyo',
            'C' => 'Bangkok',
            'D' => 'Seoul',
        ]);

        $question = new SingleChoiceQuestion(
            id: new QuestionID(1),
            text: new QuestionText('What is the capital of Vietnam?'),
            score: new Score(10),
            options: $options,
            correct: 'A',
        );

        $this->assertSame(
            $options,
            $question->options()
        );
    }

    public function test_it_throws_exception_when_answer_type_is_invalid(): void
    {
        $question = new SingleChoiceQuestion(
            id: new QuestionID(1),
            text: new QuestionText('What is the capital of Vietnam?'),
            score: new Score(10),
            options: new OptionCollection([
                'A' => 'Hanoi',
                'B' => 'Tokyo',
            ]),
            correct: 'A',
        );

        $this->expectException(
            InvalidArgumentException::class
        );

        $question->grade(new TrueFalseAnswer(true));
    }
}