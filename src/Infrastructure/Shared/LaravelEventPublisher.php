<?php

namespace Testcenter\Infrastructure\Shared;

use Illuminate\Contracts\Events\Dispatcher;
use Testcenter\Domain\Shared\DomainEvent;
use Testcenter\Domain\Shared\DomainEventPublisher;

class LaravelEventPublisher implements DomainEventPublisher
{
    public function __construct(
        private readonly Dispatcher $dispatcher
    ) {
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->dispatcher->dispatch($event);
        }
    }
}