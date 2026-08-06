<?php
namespace src\Presenter\ViewModel;

use src\Domain\Entity\Feat;

class FeatPageView
{
    /** @param LinkView[] $origins */
    public function __construct(
        public Feat $feat,
        public array $origins,
        public ?Feat $previous = null,
        public ?Feat $next = null,
    ) {}
}
