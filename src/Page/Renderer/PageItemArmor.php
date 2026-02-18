<?php
namespace src\Page\Renderer;

use src\Constant\Field;
use src\Constant\Template;
use src\Utils\UrlGenerator;

class PageItemArmor extends PageDetail
{
    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::item($slug);
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
