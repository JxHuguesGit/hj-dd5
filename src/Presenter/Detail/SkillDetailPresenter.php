<?php
namespace src\Presenter\Detail;

use src\Constant\Constant;
use src\Presenter\ViewModel\SkillPageView;
use src\Utils\Html;

class SkillDetailPresenter
{
    public function present(
        SkillPageView $viewData
    ): array {
        return [
            Constant::CST_TITLE => $viewData->skill->name,

            Constant::CST_ABILITIES     => $viewData->ability->name,
            Constant::CST_DESCRIPTION   => $viewData->skill->description,
            Constant::CST_SUBSKILLS     => $this->formatSubSkills($viewData->subSkills),

            Constant::CST_PREV => $viewData->previous ? [
                Constant::CST_NAME => $viewData?->previous->name,
                Constant::CST_SLUG => $viewData?->previous->getSlug(),
            ] : null,

            Constant::CST_NEXT => $viewData->next ? [
                Constant::CST_NAME => $viewData?->next->name,
                Constant::CST_SLUG => $viewData?->next->getSlug(),
            ] : null,
        ];
    }

    private function formatSubSkills(iterable $abilities): string
    {
        $parts = [];
        foreach ($abilities as $ability) {
            $name = $ability->name ?? '';
            $desc = $ability->description ?? '';
            $parts[] = Html::getBalise('dt', $name).Html::getBalise('dd', $desc);
        }
        return $parts ? Html::getBalise('dl', implode('', $parts), [Constant::CST_CLASS=>'my-0']) : '-';
    }
}
