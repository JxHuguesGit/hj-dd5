<?php
namespace src\Presenter\ViewModel;

use src\Domain\Entity\Feat;

class FeatPageView
{
    public function __construct(
        public Feat $feat,
        public ?array $origins = null,
        public ?Feat $previous = null,
        public ?Feat $next = null,
    ) {}

    public function __get(string $name): mixed
    {
        if(property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }
}
