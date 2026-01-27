<?php
namespace src\Domain\Result;

use src\Collection\Collection;

final class SpellResult
{
    public function __construct(
        public readonly Collection $collection,
        public readonly int $foundPosts = 0,
        public readonly int $maxNumPages = 1,
        public readonly int $currentPage = 1
    ) {}

    public function hasMore(): bool
    {
        return $this->currentPage < $this->maxNumPages;
    }
}
