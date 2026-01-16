<?php
namespace src\Page;

use src\Constant\Constant;
use src\Constant\Template;
use src\Utils\UrlGenerator;

class PageSpecie extends PageDetail
{
    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::specie($slug);
    }
    
    public function render(string $menuHtml, array $data): string
    {
        return $this->renderDetail(
            $menuHtml,
            $data,
            Template::SPECIE_DETAIL_CARD,
            [
                $data[Constant::CST_TITLE] ?? '',
                $data[Constant::CST_DESCRIPTION] ?? '',
                $data[Constant::CST_CREATURE_TYPE] ?? '-',
                $data[Constant::CST_SIZE_CATEGORY] ?? '-',
                $data[Constant::CST_SPEED] ?? '-',
                $data[Constant::CST_POWERS] ?? '-',
            ]
        );
    }
}
