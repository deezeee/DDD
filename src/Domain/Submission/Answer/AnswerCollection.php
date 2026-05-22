<?php

namespace Testcenter\Domain\Submission\Answer;

use ArrayIterator;
use Countable;
use Testcenter\Domain\Question\QuestionID;

class AnswerCollection implements Countable, \IteratorAggregate
{
    /**
     * @var Answer[]
     */
    private array $answers = [];

    /**
     * @param Answer[] $answers
     */
    public function __construct(array $answers)
    {
        foreach ($answers as $questionId => $answer) {
            $this->add(new QuestionID($questionId), $answer);
        }
    }

    public function add(QuestionID $questionId, Answer $answer): void
    {
        $questionIdValue = $questionId->value();
        if (isset($this->answers[$questionIdValue])) {
            throw new \LogicException(
                "Duplicate answer for question {$questionIdValue}"
            );
        }

        $this->answers[$questionIdValue] = $answer;
    }

    public function findByQuestionId(QuestionID $questionId): ?Answer
    {
        return $this->answers[$questionId->value()] ?? null;
    }

    public function contains(QuestionID $questionId): bool
    {
        return isset($this->answers[$questionId->value()]);
    }

    /**
     * @return Answer[]
     */
    public function all(): array
    {
        return $this->answers;
    }

    public function count(): int
    {
        return count($this->answers);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->all());
    }
}
