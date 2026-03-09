<?php

namespace src\Domain\Criteria\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Equals
{
    public function __construct(
        public string $field,
        public ?string $alias = null
    ) {}
}

