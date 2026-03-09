<?php
namespace src\Presenter\ViewModel;

use src\Domain\Entity\Item;

class GearPageView implements PageViewInterface
{
    public function __construct(
        public Item $item,
        public ?Item $previous = null,
        public ?Item $next = null
    ) {}

    public function getSlug(): string
    {
        return $this->item->slug;
    }

    public function getName(): string
    {
        return $this->item->name;
    }
}
