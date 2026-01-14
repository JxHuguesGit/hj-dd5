<?php
namespace src\Domain\Criteria;

final class OriginCriteria
{
    public ?int $featId = null;
    public ?string $type = null;
    public ?string $slug = null;
    public ?string $name = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;
}
