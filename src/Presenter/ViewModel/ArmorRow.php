<?php
namespace src\Presenter\ViewModel;

final class ArmorRow
{
    public function __construct(
        public string $name,
        public string $url,
        public string $armorClass,
        public string $strengthPenalty,
        public string $stealth,
        public string $weight,
        public string $price
    ) {}
}
