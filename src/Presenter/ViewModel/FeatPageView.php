<?php
namespace src\Presenter\ViewModel;

use src\Domain\Entity\Feat;

class FeatPageView
{
    public function __construct(
        public Feat $feat,
        /** @var LinkView[] */
        public array $origins,
        public ?Feat $previous = null,
        public ?Feat $next = null,
    ) {}
}
