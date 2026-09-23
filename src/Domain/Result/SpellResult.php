<?php
namespace src\Domain\Result;

use src\Collection\Collection;

final class SpellResult
{
    public function __construct(
        public readonly Collection $collection,
        public readonly bool $hasMore = false,
    ) {}
}
