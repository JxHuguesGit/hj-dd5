<?php
namespace src\Presenter\Detail;

use src\Constant\Bootstrap as B;
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
            Constant::TITLE       => $viewData->skill->name,

            Constant::ABILITIES   => $viewData->ability->name,
            Constant::DESCRIPTION => $viewData->skill->description,
            Constant::SUBSKILLS   => $this->formatSubSkills($viewData),
            Constant::ORIGINES        => $this->formatOrigines($viewData),

            Constant::PREV        => $viewData->previous ? [
                Constant::NAME => $viewData?->previous->name,
                Constant::SLUG => $viewData?->previous->getSlug(),
            ] : null,

            Constant::NEXT        => $viewData->next ? [
                Constant::NAME => $viewData?->next->name,
                Constant::SLUG => $viewData?->next->getSlug(),
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
                [Constant::CLASS => implode(' ', [B::BADGE, B::BG_DARK])]
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
        return $parts ? Html::getBalise('dl', implode('', $parts), [Constant::CLASS => 'my-0']) : '-';
    }
}
