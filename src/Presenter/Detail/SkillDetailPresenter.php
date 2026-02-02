<?php
namespace src\Presenter\Detail;

use src\Constant\Constant;
use src\Presenter\ViewModel\SkillPageView;
use src\Service\Domain\WpPostService;
use src\Service\Reader\SubSkillReader;
use src\Utils\Html;

class SkillDetailPresenter
{
    public function __construct(
        private SubSkillReader $subSkillReader
    ) {}

    public function present(
        SkillPageView $viewData
    ): array {

        return [
            /*
            Constant::CST_TITLE => $viewData->specie->name,
            Constant::CST_SLUG  => $viewData->specie?->getSlug(),

            Constant::CST_DESCRIPTION   => $this->cleanContent($wpPost->post_content ?? ''),
            Constant::CST_CREATURE_TYPE => $this->wpPostService?->getField(Constant::CST_CREATURE_TYPE),
            Constant::CST_SIZE_CATEGORY => $this->wpPostService?->getField(Constant::CST_SIZE_CATEGORY),
            Constant::CST_SPEED         => $this->wpPostService?->getField(Constant::CST_SPEED),
            Constant::CST_POWERS        => $this->formatAbilities($viewData->abilities),

            Constant::CST_PREV => $viewData->previous ? [
                Constant::CST_NAME => $viewData?->previous->name,
                Constant::CST_SLUG => $viewData?->previous->getSlug(),
            ] : null,

            Constant::CST_NEXT => $viewData->next ? [
                Constant::CST_NAME => $viewData?->next->name,
                Constant::CST_SLUG => $viewData?->next->getSlug(),
            ] : null,
            */
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
        return $parts ? Html::getBalise('dl', implode('', $parts), [Constant::CST_CLASS=>'my-0']) : '-';
    }

    private function cleanContent(string $content): string
    {
        return preg_replace('/<p>|<\/p>/', '', $content);
    }
}
