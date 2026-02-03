<?php
namespace src\Presenter\Detail;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Presenter\ViewModel\SkillPageView;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class SkillDetailPresenter
{
    public function present(
        SkillPageView $viewData
    ): array {
        return [
            Constant::CST_TITLE => $viewData->skill->name,

            Constant::CST_ABILITIES     => $viewData->ability->name,
            Constant::CST_DESCRIPTION   => $viewData->skill->description,
            Constant::CST_SUBSKILLS     => $this->formatSubSkills($viewData),
            Constant::ORIGINES          => $this->formatOrigines($viewData),

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

    private function formatOrigines(SkillPageView $viewData): string
    {
        if ($viewData->origins === null) {
            return '';
        }
        $html = '';
        foreach ($viewData->origins as $origin) {
            $html .= Html::getDiv(
                Html::getLink(
                    $origin->name,
                    UrlGenerator::origin($origin->slug),
                    Bootstrap::CSS_TEXT_WHITE
                ),
                [Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_BADGE, Bootstrap::CSS_BG_DARK])]
            ) . ' ';
        }
        return $html;
    }

    private function formatSubSkills(SkillPageView $viewData): string
    {
        if ($viewData->subSkills === null) {
            return '';
        }
        $parts = [];
        foreach ($viewData->subSkills as $subSkill) {
            $name = $subSkill->name ?? '';
            $desc = $subSkill->description ?? '';
            $parts[] = Html::getBalise('dt', $name).Html::getBalise('dd', $desc);
        }
        return $parts ? Html::getBalise('dl', implode('', $parts), [Constant::CST_CLASS=>'my-0']) : '-';
    }
}
