<?php
namespace src\Service\Page;

use src\Constant\Constant;
use src\Domain\Feat as DomainFeat;
use src\Presenter\ViewModel\FeatPageView;
use src\Service\Reader\FeatReader;
use src\Service\Reader\OriginReader;

final class FeatPageService
{
    public function __construct(
        private FeatReader $queryService,
        private OriginReader $originReader,
    ) {}

    public function build(DomainFeat $feat): FeatPageView
    {
        $nav = $this->queryService->getPreviousAndNext($feat);

        return new FeatPageView(
            $feat,
            $this->getOrigins($feat),
            $nav[Constant::CST_PREV],
            $nav[Constant::CST_NEXT],
        );
    }

    private function getOrigins(DomainFeat $feat): array
    {
        $data = [];
        $origins = $this->originReader->originsByFeat($feat);
        foreach ($origins as $origin) {
            $data[$origin->slug] = $origin->name;
        }
        return $data;
    }
}
