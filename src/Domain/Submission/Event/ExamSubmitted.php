<?php

namespace Testcenter\Domain\Submission\Event;

use Testcenter\Domain\Shared\DomainEvent;
use Testcenter\Domain\Submission\Submission;

class ExamSubmitted implements DomainEvent
{
    public function __construct(
        private readonly Submission $submission,
        private readonly \DateTimeImmutable $occurredOn = new \DateTimeImmutable()
    ) {
    }

    public function getSubmission(): Submission
    {
        return $this->submission;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}