<?php
namespace src\Page;

use src\Constant\Template;
use src\Utils\UrlGenerator;

class PageItemWeapon extends PageDetail
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
            Template::WEAPON_CARD,
            [
                $viewData['title'],
                $viewData['category'],
                $viewData['damage'],
                $viewData['masteryLink'],
                $viewData['properties'],
                $viewData['weight'],
                $viewData['goldPrice'],
            ]
        );
    }
}
