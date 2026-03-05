<?php
namespace src\Page\Renderer;

use src\Constant\Field as F;
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
                $viewData[F::ARMORTYPID],
                $viewData[F::ARMORCLASS],
                $viewData[F::STRPENALTY],
                $viewData[F::STHDISADV],
                $viewData[F::WEIGHT],
                $viewData[F::GOLDPRICE],
            ]
        );
    }
}
