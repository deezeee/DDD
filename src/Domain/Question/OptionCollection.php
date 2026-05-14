<?php

namespace Testcenter\Domain\Question;

class OptionCollection
{
    public function __construct(
        /** @var array<string> $options */
        public readonly array $options
    ) {
        if (empty($options)) {
            throw new \InvalidArgumentException(
                'Options cannot be empty'
            );
        }
    }
}