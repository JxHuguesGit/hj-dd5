<?php
namespace src\Presenter\Detail;

use src\Constant\Constant as C;
use src\Domain\Entity\Specie;
use src\Presenter\ViewModel\LinkView;
use src\Presenter\ViewModel\SpeciePageView;
use src\Presenter\ViewModel\SpecieDetailView;
use src\Service\Domain\WpPostService;
use src\Service\Formatter\ShortcodeFormatter;

class SpecieDetailPresenter
{
    public function __construct(
        private WpPostService $wpPostService,
        private ShortcodeFormatter $shortcodeFormatter
    ) {}

    public function present(
        SpeciePageView $viewData
    ): SpecieDetailView {

        $wpPost = $this->wpPostService
            ->getById($viewData->specie->postId);

        return new SpecieDetailView(
            name: $viewData->specie->name,
            slug: $viewData->specie->getSlug(),

            description:
                $this->cleanContent($wpPost->post_content ?? ''),

            creatureType:
                (string)$this->wpPostService->getField(C::CREATURE_TYPE),

            sizeCategory:
                (string)$this->wpPostService->getField(C::SIZE_CATEGORY),

            speed:
                (string)$this->wpPostService->getField(C::SPEED),

            abilities: $this->buildAbilities($viewData->abilities),

            previous:
                $this->buildLink($viewData->previous),

            next:
                $this->buildLink($viewData->next)
        );
    }

    private function buildAbilities(iterable $abilities): array
    {
        $result = [];

        foreach ($abilities as $ability) {
            $ability->description = $this->shortcodeFormatter->parse(
                nl2br($ability->description)
            );

            $result[] = $ability;
        }

        return $result;
    }

    private function cleanContent(string $content): string
    {
        return apply_filters('the_content', $content);
    }

    private function buildLink(?Specie $specie): ?LinkView
    {
        if ($specie === null) {
            return null;
        }

        return new LinkView(
            name: $specie->name,
            slug: $specie->getSlug(),
        );
    }
}
