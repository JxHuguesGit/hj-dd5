<?php
namespace src\Page\Renderer;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Constant\Template as T;
use src\Utils\UrlGenerator;

class PageItemTool extends PageDetail
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
            T::TOOL_CARD,
            [
                $title,
                $viewData[C::DESCRIPTION],
                $viewData[F::PARENTNAME],
                $viewData[F::WEIGHT],
                $viewData[F::GOLDPRICE],
            ]
        );
    }
}
