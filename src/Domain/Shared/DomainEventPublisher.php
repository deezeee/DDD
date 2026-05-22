<?php

namespace Testcenter\Domain\Shared;

interface DomainEventPublisher
{
    public function publish(DomainEvent ...$events): void;
}
