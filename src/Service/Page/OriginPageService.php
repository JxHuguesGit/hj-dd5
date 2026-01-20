<?php
namespace src\Service\Page;

use src\Constant\Constant;
use src\Domain\Origin as DomainOrigin;
use src\Presenter\ViewModel\OriginPageView;
use src\Service\Domain\OriginService;
use src\Service\Reader\OriginReader;

final class OriginPageService
{
    public function __construct(
        private OriginService $originService,
        private OriginReader $queryService,
    ) {}

    public function build(DomainOrigin $origin): OriginPageView
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
            $this->originService->getItems($origin),
        );
    }
}
