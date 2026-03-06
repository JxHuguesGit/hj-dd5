<?php
namespace src\Service\Page;

use src\Constant\Constant as C;
use src\Domain\Entity\Feat;
use src\Presenter\ViewModel\FeatPageView;
use src\Service\Reader\FeatReader;
use src\Service\Reader\OriginReader;

final class FeatPageService
{
    public function __construct(
        private FeatReader $queryService,
        private OriginReader $originReader,
    ) {}

    public function build(Feat $feat): FeatPageView
    {
        $nav = $this->queryService->getPreviousAndNext($feat);

        return new FeatPageView(
            $feat,
            $this->getOrigins($feat),
            $nav[C::PREV],
            $nav[C::NEXT],
        );
    }

    private function getOrigins(Feat $feat): array
    {
        $data = [];
        $origins = $this->originReader->originsByFeat($feat);
        foreach ($origins as $origin) {
            $data[$origin->slug] = $origin->name;
        }
        return $data;
    }
}
