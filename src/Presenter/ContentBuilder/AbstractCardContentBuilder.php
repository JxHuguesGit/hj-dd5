<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Constant as C;
use src\Utils\Html;

abstract class AbstractCardContentBuilder implements ContentBuilderInterface
{
    public function build(object $groups, array $params = []): string
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
            'section',
            $this->renderGroupTitle($group) . $grid,
            [
                C::CSSCLASS => $this->getGroupClass(),
                C::ID => htmlspecialchars($group->slug),
            ]
        );
    }

    abstract protected function renderItem(object $row): string;

    abstract protected function renderGroupTitle(object $group): string;

    abstract protected function getGroupsClass(): string;

    abstract protected function getGroupClass(): string;

    abstract protected function getGridClass(): string;
}
