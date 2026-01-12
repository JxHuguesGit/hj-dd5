<?php
namespace src\Presenter\ViewModel;

use src\Domain\Feat as DomainFeat;

class FeatPageView
{
    public function __construct(
        public DomainFeat $feat,
        public ?DomainFeat $previous = null,
        public ?DomainFeat $next = null,
    ) {}

    public function __get(string $name): mixed
    {
        if(property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }
}
