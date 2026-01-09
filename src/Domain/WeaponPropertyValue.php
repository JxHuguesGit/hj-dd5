<?php
namespace src\Domain;

final class WeaponPropertyValue
{
    public string $slug;

    public ?int $minRange = null;
    public ?int $maxRange = null;
    public ?string $versatileDamage = null;
    public ?string $ammunitionType = null;
}
