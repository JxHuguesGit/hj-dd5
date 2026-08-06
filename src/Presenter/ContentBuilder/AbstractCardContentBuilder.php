<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Utils\Html;

abstract class AbstractCardContentBuilder implements ContentBuilderInterface
{
    public function build(object $groups): string
    {
        $contentHtml = '';

        foreach ($groups as $group) {
            $contentHtml .= $this->renderGroup($group);
        }

        return Html::getDiv(
            $contentHtml,
            [C::CSSCLASS => $this->getGroupsClass()]
        );
    }

    protected function renderGroup(object $group): string
    {
        $content = '';

        foreach ($group->rows as $row) {
            $content .= $this->renderItem($row);
        }

        $grid = Html::getDiv(
            $content,
            [C::CSSCLASS => $this->getGridClass()]
        );

        return Html::getBalise(
            H::BALISE_SECTION,
            $this->renderGroupTitle($group) . $grid,
            [
                C::CSSCLASS => $this->getGroupClass(),
                C::ID => htmlspecialchars($group->slug),
            ]
        );
    }

    protected function renderGroupTitle(object $group): string
    {
        if ($group->label === '') {
            return '';
        }

        return Html::getBalise(
            H::BALISE_H2,
            htmlspecialchars($group->label),
            [C::CSSCLASS => B::DATA_GROUP_TITLE]
        );
    }

    protected function renderCard(string $content, string $specificClass): string
    {
        return Html::getBalise(
            H::BALISE_ARTICLE,
            $content,
            [C::CSSCLASS => B::DATA_CARD . L::SPACE . $specificClass]
        );
    }

    protected function renderInfo(string $label, string $value, array $attributes = []): string
    {
        if ($value === '') {
            return '';
        }

        return Html::getBalise(
            H::BALISE_P,
            sprintf(L::STRONG_INFO, $label, htmlspecialchars($value)),
            $attributes
        );
    }

    abstract protected function renderItem(object $row): string;

    protected function getGroupsClass(): string
    {
        return B::DATA_LIST;
    }

    protected function getGroupClass(): string
    {
        return B::DATA_GROUP;
    }

    protected function getGridClass(): string
    {
        return B::DATA_GRID;
    }

}
