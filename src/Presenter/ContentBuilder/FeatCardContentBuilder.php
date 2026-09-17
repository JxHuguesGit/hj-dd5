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
    public function build(object $groups): string
    {
        $content = $this->getCategoryFilters($groups)
            . $this->getSourceFilters($groups);

        return $content . parent::build($groups);
    }

    private function getCategoryFilters(object $groups): string
    {
        $categories = [];
        foreach ($groups as $group) {
            $categories['feat' . $group->slug] = $group->label;
        }
        if ($categories===[]) {
            return '';
        }

        $content = '';
        foreach ($categories as $code => $name) {
            $content .= Html::getBalise(
                H::BALISE_BUTTON,
                htmlspecialchars($name),
                [
                    C::CSSCLASS => 'badge bg-dark type-filter active',
                    'type' => 'button',
                    'data-type' => $code,
                ]
            ) . ' ';
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => 'type-filters mb-2']
        );
    }

    protected function getGroupId (object $group): string
    {
        return 'feat' . parent::getGroupId($group);
    }

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
                [C::CSSCLASS => B::FEAT_PREREQUIS]
            );
        }

        return $this->renderCard($htmlContent, B::FEAT_CARD . ' source source-' . $row->sourceCode);
    }

    /** @param FeatGroup $group */
    protected function renderGroupTitle(object $group): string
    {
        $title = htmlspecialchars($group->label);

        if ($group->extraPrerequis !== '') {
            $title .= ' (' . Html::getBalise(
                H::BALISE_SMALL,
                htmlspecialchars($group->extraPrerequis),
            ) . ')';
        }

        return Html::getBalise(
            H::BALISE_H2,
            $title,
            [C::CSSCLASS => B::DATA_GROUP_TITLE]
        );
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
                [C::CSSCLASS => C::FEAT_ORIGIN]
            );
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => C::FEAT_ORIGINS]
        );
    }

}
