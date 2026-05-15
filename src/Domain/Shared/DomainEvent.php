<?php

namespace Testcenter\Domain\Shared;

interface DomainEvent
{
    public function occurredOn(): \DateTimeImmutable;
}