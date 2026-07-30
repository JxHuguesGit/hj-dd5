<?php
namespace src\Presenter\Detail;

use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Domain\Entity\Feat;
use src\Presenter\ViewModel\FeatDetailView;
use src\Presenter\ViewModel\FeatPageView;
use src\Presenter\ViewModel\FeatTypeView;
use src\Presenter\ViewModel\LinkView;
use src\Service\Domain\WpPostService;

class FeatDetailPresenter
{
    public function __construct(
        private WpPostService $wpPostService
    ) {}

    public function present(
        FeatPageView $viewData
    ): FeatDetailView {
        $wpPost = $this->wpPostService->getById($viewData->feat->postId);

        return new FeatDetailView(
            name: $viewData->feat->name,
            slug: $viewData->feat->getSlug(),
            description: $this->cleanContent($wpPost->post_content ?? ''),
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
        return match ($viewData->feat->featTypeId) {
            Feat::TYPE_ORIGIN => new FeatTypeView(
                label: L::ORIGIN_FEAT,
                slug: C::ORIGIN,
            ),

            Feat::TYPE_GENERAL => new FeatTypeView(
                label: L::GENERAL_FEAT,
                slug: C::GENERAL,
                prerequisite: $this->buildGeneralPrerequisite(),
            ),

            Feat::TYPE_COMBAT => new FeatTypeView(
                label: L::CBT_STYLE_FEAT,
                slug: C::COMBAT,
                prerequisite: C::PREREQUIS_ASDC,
            ),

            Feat::TYPE_EPIC => new FeatTypeView(
                label: L::CBT_STYLE_EPIC,
                slug: C::EPIC,
                prerequisite: $this->buildEpicPrerequisite(),
            ),

            default => new FeatTypeView(
                label: 'Don non identifié',
                slug: '',
            ),
        };
    }

    private function buildGeneralPrerequisite(): ?string
    {
        $prerequisite = $this->wpPostService->getField(C::PREREQUIS);

        if (!$prerequisite) {
            return C::PREREQUIS_NIV4;
        }

        return C::PREREQUIS_NIV4 . ', ' . ucfirst($prerequisite);
    }

    private function buildEpicPrerequisite(): ?string
    {
        $prerequisite = $this->wpPostService->getField(C::PREREQUIS);

        if (!$prerequisite) {
            return C::PREREQUIS_NIV19;
        }

        return C::PREREQUIS_NIV19 . ', ' . ucfirst($prerequisite);
    }

    private function cleanContent(string $content): string
    {
        return preg_replace('/<p>|<\/p>/', '', $content);
    }
}
