<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Template;

class AdminPage extends Utilities
{
	private array $allowedOnglets = [
    	'home',
        'character',
        'timeline',
        'compendium',
    ];
    
    public function getAdminContentPage(string $content): string
    {
        $attributes = [
        	'Hugues Joneaux',// WPUser username
            $this->getSidebar(),// Menu de la sidebar
            $content
        ];
        return $this->getRender(Template::ADMINBASE, $attributes);
    }
    
    protected function getSidebar(): string
    {
        $currentTab = $this->getArrParams(Constant::ONGLET, 'home');
        $currentId = $this->getArrParams('id', '');
    	$sidebar = new AdminSidebar();
        $sidebar->setAttributes(
        	$this->allowedOnglets,
            $currentTab,
            $currentId
        );
    	return $sidebar->getContent();
    }

    public static function getAdminController(array $arrUri): mixed
    {
        $controller = new AdminPage($arrUri);
        $currentTab = $controller->getArrParams(Constant::ONGLET, 'home');
        switch ($currentTab) {
        	case 'character' :
                $controller = new AdminCharacterPage($arrUri);
			break;
        	case 'compendium' :
                $controller = new AdminCompendiumPage($arrUri);
			break;
			case 'home' :
            default :
                $controller = new AdminHomePage($arrUri);
			break;
        }
        return $controller;
    }
}