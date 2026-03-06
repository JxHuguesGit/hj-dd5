<?php
namespace src\Presenter\Detail;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Presenter\ViewModel\SkillPageView;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class SkillDetailPresenter
{
    public function present(
        SkillPageView $viewData
    ): array {
        return [
            C::TITLE       => $viewData->skill->name,

            C::ABILITIES   => $viewData->ability->name,
            C::DESCRIPTION => $viewData->skill->description,
            C::SUBSKILLS   => $this->formatSubSkills($viewData),
            C::ORIGINES        => $this->formatOrigines($viewData),

            C::PREV        => $viewData->previous ? [
                C::NAME => $viewData?->previous->name,
                C::SLUG => $viewData?->previous->getSlug(),
            ] : null,

            C::NEXT        => $viewData->next ? [
                C::NAME => $viewData?->next->name,
                C::SLUG => $viewData?->next->getSlug(),
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
                    B::TEXT_WHITE
                ),
                [C::CSSCLASS => implode(' ', [B::BADGE, B::BG_DARK])]
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
            $name    = $subSkill->name ?? '';
            $desc    = $subSkill->description ?? '';
            $parts[] = Html::getBalise('dt', $name) . Html::getBalise('dd', $desc);
        }
        return $parts ? Html::getBalise('dl', implode('', $parts), [C::CSSCLASS => 'my-0']) : '-';
    }
}
