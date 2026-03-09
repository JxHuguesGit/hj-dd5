<?php
namespace src\Presenter\ViewModel;

use src\Domain\Entity\Weapon;

class WeaponPageView implements PageViewInterface
{
    public function __construct(
        public Weapon $item,
        public ?Weapon $previous = null,
        public ?Weapon $next = null
    ) {
    }

    public function getSlug(): string
    {
        return $this->item->slug;
    }

    public function getName(): string
    {
        return $this->item->name;
    }
}
