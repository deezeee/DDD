<?php

namespace Testcenter\Domain\Question\Pair;

use InvalidArgumentException;

class MatchingPairs
{
    /**
     * @param MatchingPair[] $pairs
     */
    public function __construct(
        private readonly array $pairs,
    ) {
        $this->ensureUniqueLeft();
        $this->ensureUniqueRight();
    }

    public function all(): array
    {
        return $this->pairs;
    }

    private function ensureUniqueLeft(): void
    {
        $lefts = array_map(
            fn(MatchingPair $pair) => $pair->left(),
            $this->pairs,
        );

        if (count($lefts) !== count(array_unique($lefts))) {
            throw new InvalidArgumentException('Duplicate left matching detected');
        }
    }

    private function ensureUniqueRight(): void
    {
        $rights = array_map(
            fn(MatchingPair $pair) => $pair->right(),
            $this->pairs,
        );

        if (count($rights) !== count(array_unique($rights))) {
            throw new InvalidArgumentException('Duplicate right matching detected');
        }
    }

    public function total(): int
    {
        return count($this->pairs);
    }

    public function isCorrect(string $left, string $right): bool
    {
        foreach ($this->pairs as $pair) {
            if ($pair->left() === $left && $pair->right() === $right) {
                return true;
            }
        }

        return false;
    }
}