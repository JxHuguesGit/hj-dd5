<?php
namespace src\Service;

use src\Constant\Constant;
use src\Domain\Feat as DomainFeat;
use src\Presenter\ViewModel\FeatPageView;
use src\Service\Reader\FeatReader;

final class FeatPageService
{
    public function __construct(
        private FeatReader $queryService,
    ) {}

    public function build(DomainFeat $feat): FeatPageView
    {
        $nav = $this->queryService->getPreviousAndNext($feat);

        return new FeatPageView(
            $feat,
            $nav[Constant::CST_PREV],
            $nav[Constant::CST_NEXT],
        );
    }
}
