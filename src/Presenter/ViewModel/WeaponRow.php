<?php
namespace src\Presenter\ViewModel;

final class WeaponRow
{
    public function __construct(
        public string $name,
        public string $url,
        public string $damage,
        public string $properties,
        public string $masteryLink,
        public string $weight,
        public string $price
    ) {}
}
