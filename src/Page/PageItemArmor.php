<?php
namespace src\Page;

use src\Constant\Constant;
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
            'slug' => 'items-armor',
            'icon' => 'fa-solid fa-shield-halved',
            'title' => 'Armures',
            'description' => 'Les armures disponibles pour les aventuriers.',
            'url' => Routes::ITEMS_PREFIX.Constant::CST_ARMOR,
            'order' => 51,
            'parent' => 'items',
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
                $viewData['armorTypeId'],
                $viewData['armorClass'],
                $viewData['strengthPenalty'],
                $viewData['stealthDisadvantage'],
                $viewData['weight'],
                $viewData['goldPrice'],
            ]
        );
    }
}
