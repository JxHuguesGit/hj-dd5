<?php
namespace src\Presenter\Detail;

use src\Domain\Entity\Feat;
use src\Presenter\ViewModel\FeatDetailView;
use src\Presenter\ViewModel\FeatPageView;
use src\Presenter\ViewModel\FeatTypeView;
use src\Presenter\ViewModel\LinkView;
use src\Service\Domain\FeatPreRequisService;
use src\Service\Reader\FeatTypeReader;
use src\Utils\Utils;

class FeatDetailPresenter
{
    public function __construct(
        private FeatTypeReader $featTypeReader,
        private FeatPreRequisService $featPreRequisService
    ) {}

    public function present(
        FeatPageView $viewData
    ): FeatDetailView {
        return new FeatDetailView(
            name: $viewData->feat->name,
            slug: $viewData->feat->slug,
            description: Utils::formatBBCode($viewData->feat->description ?? ''),
            sourceCode: $this->getCode($viewData),
            type: $this->buildType($viewData),
            origins: $this->buildOrigins($viewData),
            previous: $this->buildLink($viewData->previous),
            next: $this->buildLink($viewData->next)
        );
    }

    private function getCode(FeatPageView $viewData): string
    {
        $reference = $this->featPreRequisService->getReferenceForFeat($viewData->feat);
        if ($reference === null) {
            return '';
        }
        return strtolower($reference->code);
    }

    private function buildOrigins(FeatPageView $viewData): array
    {
        return $viewData->origins;
    }

    private function buildLink(?Feat $feat): ?LinkView
    {
        if ($feat === null) {
            return null;
        }

        return new LinkView(
            name: $feat->name,
            slug: $feat->getSlug(),
        );
    }

    private function buildType(FeatPageView $viewData): FeatTypeView
    {
        $featType = $this->featTypeReader->featTypeById($viewData->feat->featTypeId);
        $prerequisite = $this->buildPrerequisite($viewData->feat);
        if ($prerequisite!='') {
            $prerequisite = ' (' . $prerequisite . ')';
        }

        return new FeatTypeView(
            label: $featType->name,
            slug: $featType->slug,
            prerequisite: $prerequisite,
        );
    }

    private function buildPrerequisite(Feat $feat): ?string
    {
        $preRequis = $this->featPreRequisService->preRequisForFeatWithType($feat);

        if ($preRequis->isEmpty()) {
            return null;
        }

        $names = [];

        foreach ($preRequis as $preRequisItem) {
            $names[] = $preRequisItem->name;
        }

        return implode(', ', $names);
    }
}
