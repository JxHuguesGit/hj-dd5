<?php
namespace src\Presenter\Detail;

use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Domain\Entity\Feat;
use src\Presenter\ViewModel\FeatDetailView;
use src\Presenter\ViewModel\FeatPageView;
use src\Presenter\ViewModel\FeatTypeView;
use src\Presenter\ViewModel\LinkView;
use src\Service\Domain\FeatPreRequisService;

class FeatDetailPresenter
{
    public function __construct(
        private FeatPreRequisService $featPreRequisService
    ) {}

    public function present(
        FeatPageView $viewData
    ): FeatDetailView {
        return new FeatDetailView(
            name: $viewData->feat->name,
            slug: $viewData->feat->slug,
            description: $this->cleanContent($viewData->feat->description ?? ''),
            type: $this->buildType($viewData),
            origins: $this->buildOrigins($viewData),
            previous: $this->buildLink($viewData->previous),
            next: $this->buildLink($viewData->next)
        );
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
        $prerequisite = $this->buildPrerequisite($viewData->feat);

        return match ($viewData->feat->featTypeId) {
            Feat::TYPE_ORIGIN => new FeatTypeView(
                label: L::ORIGIN_FEAT,
                slug: C::ORIGIN,
                prerequisite: $prerequisite,
            ),

            Feat::TYPE_GENERAL => new FeatTypeView(
                label: L::GENERAL_FEAT,
                slug: C::GENERAL,
                prerequisite: ' (' . $prerequisite . ')',
            ),

            Feat::TYPE_COMBAT => new FeatTypeView(
                label: L::CBT_STYLE_FEAT,
                slug: C::COMBAT,
                prerequisite: ' (' . $prerequisite . ')',
            ),

            Feat::TYPE_EPIC => new FeatTypeView(
                label: L::CBT_STYLE_EPIC,
                slug: C::EPIC,
                prerequisite: ' (' . $prerequisite . ')',
            ),

            default => new FeatTypeView(
                label: 'Don non identifié',
                slug: '',
                prerequisite: '',
            ),
        };
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

    private function cleanContent(string $content): string
    {
        return preg_replace('/<p>|<\/p>/', '', $content);
    }
}
