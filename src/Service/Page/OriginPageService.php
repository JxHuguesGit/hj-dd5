<?php
namespace src\Service\Page;

use src\Constant\Constant;
use src\Domain\RpgOrigin;
use src\Presenter\ViewModel\OriginPageView;
use src\Service\RpgOriginService;
use src\Service\RpgOriginQueryService;

final class OriginPageService
{
    public function __construct(
        private RpgOriginService $originService,
        private RpgOriginQueryService $queryService,
    ) {}

    public function build(RpgOrigin $origin): OriginPageView
    {
        $nav = $this->queryService->getPreviousAndNext($origin);

        return new OriginPageView(
            $origin,
            $nav[Constant::CST_PREV],
            $nav[Constant::CST_NEXT],
            $this->originService->getFeat($origin),
            $this->originService->getTool($origin),
            $this->originService->getAbilities($origin),
            $this->originService->getSkills($origin),
        );
    }
}
