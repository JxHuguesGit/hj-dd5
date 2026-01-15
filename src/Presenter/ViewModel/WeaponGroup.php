<?php
namespace src\Presenter\ViewModel;

class WeaponGroup
{
    public function __construct(
        public string $label,
        public string $slug,
        /** @var DomainWeapon[] */
        public array $weapons
    ) {}
}
