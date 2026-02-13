<?php
namespace src\Presenter\ViewModel;

use src\Domain\Entity\Armor;

class ArmorPageView implements PageViewInterface
{
    public function __construct(
        public Armor $armor,
        public ?Armor $previous = null,
        public ?Armor $next = null
    ) {}

    public function getSlug(): string
    {
        return $this->armor->slug;
    }

    public function getName(): string
    {
        return $this->armor->name;
    }
}
