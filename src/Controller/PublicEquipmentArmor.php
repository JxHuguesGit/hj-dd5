<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Controller\RpgArmor as ControllerRpgArmor;
use src\Constant\Template;
use src\Model\PageRegistry;
use src\Page\PageEquipmentArmor;
use src\Presenter\MenuPresenter;
use src\Service\RpgArmorService;

final class PublicEquipmentArmor extends PublicBase
{
    private ?Collection $armors = null;

    public function __construct(
        private RpgArmorService $armorService
    ) {
        $this->title = "Matériel - Armures";
        $this->armors = $this->armorService->getAllArmors();

        $pageElement = (new PageEquipmentArmor())->getPageElement();
        PageRegistry::getInstance()->register($pageElement);
        $this->pageElement = $pageElement;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        $registry = PageRegistry::getInstance();
        $menuHtml = (new MenuPresenter($registry->all(), 'equipments'))->render();
        
        if ($this->armors===null || $this->armors->isEmpty()) {
            return $this->getRender(Template::NOT_FOUND, [$menuHtml]);
        }
 
        $contentHtml = ControllerRpgArmor::getTable($this->armors, ['withMarginTop'=>false]);
        $contentSection = $this->getRender(Template::CATEGORY_PAGE, [$this->getTitle(), $contentHtml->display()]);

        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}
