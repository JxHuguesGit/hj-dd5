<?php
namespace src\Presenter\ViewModel;

use src\Domain\Entity\Armor;

class ArmorPageView extends ItemPageView
{
    public function __construct(
        public Armor $armor,
        ?Armor $previous = null,
        ?Armor $next = null
    ) {
        parent::__construct($armor, $previous, $next);
    }
}
