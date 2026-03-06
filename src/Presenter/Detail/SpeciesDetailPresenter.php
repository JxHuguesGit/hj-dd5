<?php
namespace src\Presenter\Detail;

use src\Constant\Constant as C;
use src\Presenter\ViewModel\SpeciePageView;
use src\Service\Domain\WpPostService;
use src\Utils\Html;

class SpeciesDetailPresenter
{
    public function __construct(
        private WpPostService $wpPostService
    ) {}

    public function present(
        SpeciePageView $viewData
    ): array {
        $wpPost = $this->wpPostService->getById($viewData->specie->postId ?? 0);

        return [
            C::TITLE => $viewData->specie->name,
            C::SLUG  => $viewData->specie?->getSlug(),

            C::DESCRIPTION   => $this->cleanContent($wpPost->post_content ?? ''),
            C::CREATURE_TYPE => $this->wpPostService?->getField(C::CREATURE_TYPE),
            C::SIZE_CATEGORY => $this->wpPostService?->getField(C::SIZE_CATEGORY),
            C::SPEED         => $this->wpPostService?->getField(C::SPEED),
            C::POWERS        => $this->formatAbilities($viewData->abilities),

            C::PREV => $viewData->previous ? [
                C::NAME => $viewData?->previous->name,
                C::SLUG => $viewData?->previous->getSlug(),
            ] : null,

            C::NEXT => $viewData->next ? [
                C::NAME => $viewData?->next->name,
                C::SLUG => $viewData?->next->getSlug(),
            ] : null,
        ];
    }

    private function formatAbilities(iterable $abilities): string
    {
         $parts = [];
         foreach ($abilities as $ability) {
            $name = $ability->name ?? '';
            $desc = $ability->description ?? '';
            $parts[] = Html::getBalise('dt', $name).Html::getBalise('dd', $desc);
        }
        return $parts ? Html::getBalise('dl', implode('', $parts), [C::CSSCLASS=>'my-0']) : '-';
    }

    private function cleanContent(string $content): string
    {
        return preg_replace('/<p>|<\/p>/', '', $content);
    }
}
