<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Presenter\ViewModel\LinkView;
use src\Presenter\ViewModel\SkillDetailView;
use src\Presenter\ViewModel\SubSkillView;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class SkillDetailContentBuilder extends AbstractDetailContentBuilder
{

    /** @param SkillDetailView $view */
    protected function renderDetailHeader(object $view) : string
    {
        return $this->renderHeader(
            $view->name,
            htmlspecialchars($view->ability)
        );
    }

    protected function getDetailUrl(string $slug): string
    {
        return UrlGenerator::skill($slug);
    }

    /** @param SkillDetailView $view */
    protected function renderDetailBody(object $view) : string
    {
        return
            $this->renderDescription($view)
            . $this->renderOrigins($view)
            . $this->renderSubSkills($view)
        ;
    }

    private function renderDescription(SkillDetailView $view): string
    {
        return Html::getDiv(
            htmlspecialchars($view->description),
            [C::CSSCLASS => B::DATA_DETAIL_DESCRIPTION]
        );
    }

    private function renderOrigins(SkillDetailView $view): string
    {
        if (!$view->origins) {
            return '';
        }

        $content = '';

        foreach ($view->origins as $origin) {
            /** @var LinkView $origin */
            $content .= Html::getSpan(
                Html::getLink(
                    htmlspecialchars($origin->name),
                    UrlGenerator::origin($origin->slug)
                )
            );
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::SKILL_ORIGINS]
        );
    }

    private function renderSubSkills(SkillDetailView $view): string
    {
        if (!$view->subSkills) {
            return '';
        }

        $content = '';

        foreach ($view->subSkills as $subSkill) {
            /** @var SubSkillView $subSkill */
            $content .= Html::getBalise(
                H::BALISE_ARTICLE,
                Html::getBalise(
                    H::BALISE_H2,
                    htmlspecialchars($subSkill->name)
                )
                . Html::getBalise(
                    H::BALISE_P,
                    htmlspecialchars($subSkill->description)
                ),
                [C::CSSCLASS => B::SUBSKILL]
            );
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::SKILL_SUBSKILLS]
        );
    }
}
