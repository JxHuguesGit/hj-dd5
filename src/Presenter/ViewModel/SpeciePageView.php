<?php
namespace src\Presenter\ViewModel;

use src\Collection\Collection;
use src\Domain\Entity\Specie;

class SpeciePageView
{
    public function __construct(
        public Specie $specie,
        public ?Specie $previous = null,
        public ?Specie $next = null,
        public Collection $abilities = new Collection(),
    ) {}

    public function __get(string $name): mixed
    {
        if(property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }
}
