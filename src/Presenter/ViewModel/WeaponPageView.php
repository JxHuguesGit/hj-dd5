<?php
namespace src\Presenter\ViewModel;

use src\Domain\Weapon;

class WeaponPageView extends ItemPageView
{
    public function __construct(
        public Weapon $weapon,
        ?Weapon $previous = null,
        ?Weapon $next = null
    ) {
        parent::__construct($weapon, $previous, $next);
    }
}
