<?php
namespace src\Presenter\ViewModel;

use src\Collection\Collection;
use src\Domain\Feat as DomainFeat;
use src\Domain\Item as DomainItem;
use src\Domain\Origin as DomainOrigin;

final class OriginPageView
{
    public function __construct(
        public DomainOrigin $origin,
        public ?DomainOrigin $previous = null,
        public ?DomainOrigin $next = null,
        public ?DomainFeat $feat = null,
        public ?DomainItem $tool = null,
        public Collection $abilities = new Collection(),
        public Collection $skills = new Collection(),
    ) {}

    public function __get(string $name): mixed
    {
        if(property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }
}
