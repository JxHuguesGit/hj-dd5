<?php
namespace src\Page;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Constant\Routes;
use src\Constant\Template;
use src\Model\PageElement;
use src\Utils\UrlGenerator;

class PageItemArmor extends PageDetail
{
    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::item($slug);
    }

    public function getPageElement(): PageElement
    {
        return new PageElement([
            Constant::CST_SLUG => 'items-armor',
            'icon' => 'fa-solid fa-shield-halved',
            Bootstrap::CSS_TITLE => Language::LG_ARMORS,
            Constant::CST_DESCRIPTION => 'Les armures disponibles pour les aventuriers.',
            'url' => Routes::ITEMS_PREFIX.Constant::CST_ARMOR,
            'order' => 51,
            Constant::CST_PARENT => Constant::CST_ITEMS,
        ]);
    }

    public function render(string $menuHtml, string $title, array $viewData): string
    {
        return $this->renderDetail(
            $menuHtml,
            $viewData,
            Template::ARMOR_CARD,
            [
                $title,
                $viewData[Field::ARMORTYPID],
                $viewData[Field::ARMORCLASS],
                $viewData[Field::STRPENALTY],
                $viewData[Field::STHDISADV],
                $viewData[Field::WEIGHT],
                $viewData[Field::GOLDPRICE],
            ]
        );
    }
}
