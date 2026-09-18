<?php
namespace src\Presenter\ViewModel;

use src\Collection\Collection;
use src\Domain\Entity\PreRequis;

final class FeatPreRequisResult
{
    public function __construct(
        public readonly ?PreRequis $featType,
        public readonly Collection $feat,
    ) {}
}
