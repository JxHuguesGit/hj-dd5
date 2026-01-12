<?php
namespace src\Presenter\ViewModel;

use src\Collection\Collection;
use src\Domain\Specie as DomainSpecie;

class SpeciePageView
{
    public function __construct(
        public DomainSpecie $specie,
        public ?DomainSpecie $previous = null,
        public ?DomainSpecie $next = null,
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
