<?php
namespace src\Presenter\ViewModel;

use src\Collection\Collection;
use src\Domain\RpgFeat;
use src\Domain\Item as DomainItem;
use src\Domain\RpgOrigin;

final class OriginPageView
{
    public function __construct(
        public RpgOrigin $origin,
        public ?RpgOrigin $previous = null,
        public ?RpgOrigin $next = null,
        public ?RpgFeat $feat = null,
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
