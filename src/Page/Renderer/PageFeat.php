<?php
namespace src\Page\Renderer;

use src\Constant\Constant;
use src\Constant\Template;
use src\Utils\UrlGenerator;

class PageFeat extends PageDetail
{
    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::feat($slug);
    }

    public function render(string $menuHtml, array $data): string
    {
        return $this->renderDetail(
            $menuHtml,
            $data,
            Template::FEAT_DETAIL_CARD,
            [
                '',
                $data[Constant::CST_TITLE] ?? '',
                $data[Constant::CST_DESCRIPTION] ?? '',
                $data[Constant::CST_FEATTYPE] ?? '-',
                $data[Constant::ORIGINES] ?? '',
            ]
        );
    }
}
