<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\FeatGroup;
use src\Presenter\ViewModel\FeatRow;
use src\Presenter\ViewModel\LinkView;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class FeatCardContentBuilder extends AbstractCardContentBuilder
{
    /** @param FeatRow $row */
    protected function renderItem(object $row): string
    {
        $htmlContent = Html::getBalise(H::BALISE_H3, Html::getLink($row->name, $row->url));

        if (!empty($row->origins)) {
            $htmlContent .= $this->renderOrigins($row->origins);
        }

        if ($row->prerequisite !== null) {
            $htmlContent .= Html::getBalise(
                H::BALISE_P,
                sprintf(L::PREREQUIS_TEXT, htmlspecialchars($row->prerequisite)),
                [C::CSSCLASS => 'feat-prerequisite']
            );
        }

        return Html::getBalise(H::BALISE_ARTICLE, $htmlContent, [C::CSSCLASS => B::FEAT_CARD]);
    }

    /** @param FeatGroup $group */
    protected function renderGroupTitle(object $group): string
    {
        $title = htmlspecialchars($group->label);

        if ($group->extraPrerequis !== '') {
            $title .= Html::getBalise(
                H::BALISE_SMALL,
                htmlspecialchars($group->extraPrerequis),
            );
        }

        return Html::getBalise(
            H::BALISE_H2,
            $title,
            [C::CSSCLASS => B::FEAT_GROUP_TITLE]
        );
    }
    
    protected function getGroupsClass(): string
    {
        return B::FEAT_GROUPS;
    }

    protected function getGroupClass(): string
    {
        return B::FEAT_GROUP;
    }

    protected function getGridClass(): string
    {
        return B::FEAT_GRID;
    }

    /**
     * @param LinkView[] $origins
     */
    private function renderOrigins(array $origins): string
    {
        $content = '';

        foreach ($origins as $origin) {
            $content .= Html::getDiv(
                Html::getLink(
                    htmlspecialchars($origin->name),
                    UrlGenerator::origin($origin->slug),
                    B::TEXT_WHITE
                ),
                [
                    C::CSSCLASS => implode(' ', [C::FEAT_ORIGIN, B::BADGE, B::BG_DARK])
                ]
            );
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => C::FEAT_ORIGINS]
        );
    }
    
}
