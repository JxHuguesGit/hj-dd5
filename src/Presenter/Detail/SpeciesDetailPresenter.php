<?php
namespace src\Presenter\Detail;

use src\Constant\Constant;
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
            Constant::TITLE => $viewData->specie->name,
            Constant::SLUG  => $viewData->specie?->getSlug(),

            Constant::DESCRIPTION   => $this->cleanContent($wpPost->post_content ?? ''),
            Constant::CREATURE_TYPE => $this->wpPostService?->getField(Constant::CREATURE_TYPE),
            Constant::SIZE_CATEGORY => $this->wpPostService?->getField(Constant::SIZE_CATEGORY),
            Constant::SPEED         => $this->wpPostService?->getField(Constant::SPEED),
            Constant::POWERS        => $this->formatAbilities($viewData->abilities),

            Constant::PREV => $viewData->previous ? [
                Constant::NAME => $viewData?->previous->name,
                Constant::SLUG => $viewData?->previous->getSlug(),
            ] : null,

            Constant::NEXT => $viewData->next ? [
                Constant::NAME => $viewData?->next->name,
                Constant::SLUG => $viewData?->next->getSlug(),
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
        return $parts ? Html::getBalise('dl', implode('', $parts), [Constant::CSSCLASS=>'my-0']) : '-';
    }

    private function cleanContent(string $content): string
    {
        return preg_replace('/<p>|<\/p>/', '', $content);
    }
}
