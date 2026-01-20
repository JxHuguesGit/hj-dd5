<?php
namespace src\Service\Page;

use src\Constant\Constant;
use src\Domain\Specie as DomainSpecie;
use src\Presenter\ViewModel\SpeciePageView;
use src\Service\Domain\SpecieService;
use src\Service\Reader\SpecieReader;

final class SpeciePageService
{
    public function __construct(
        private SpecieService $specieService,
        private SpecieReader $specieReader,
    ) {}

    public function build(DomainSpecie $specie): SpeciePageView
    {
        $nav = $this->specieReader->getPreviousAndNext($specie);

        return new SpeciePageView(
            $specie,
            $nav[Constant::CST_PREV],
            $nav[Constant::CST_NEXT],
            $this->specieService->getAbilities($specie),
        );
    }
}
