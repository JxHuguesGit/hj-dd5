<?php
namespace src\Presenter\ViewModel;

use src\Collection\Collection;
use src\Domain\Entity\Feat;
use src\Domain\Entity\Item;
use src\Domain\Entity\Origin;

final class OriginPageView
{
    public function __construct(
        public Origin $origin,
        public ?Origin $previous = null,
        public ?Origin $next = null,
        public ?Feat $feat = null,
        public ?Item $tool = null,
        public Collection $abilities = new Collection(),
        public Collection $skills = new Collection(),
        public Collection $items = new Collection(),
    ) {}

    public function __get(string $name): mixed
    {
        if(property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }
}
