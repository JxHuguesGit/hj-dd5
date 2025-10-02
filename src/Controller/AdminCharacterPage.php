<?php
namespace src\Controller;

use src\Constant\Template;
use src\Entity\MockHero;

class AdminCharacterPage extends AdminPage
{

    public function getAdminContentPage(string $content=''): string
    {
        // Ici, on va gérer l'affichage de la feuille de personnage.
        // On va utiliser des personnages Mock.
        $mockHero = new MockHero();

		$hero = $mockHero->getHero();
        $controller = $hero->getController();
        $attributes = $controller->getNameBlock();
        
		$completeAttributes = array_merge(
        	$attributes,
            [
                $controller->getQuickInfoBlock(), // bloc des données chiffrées
                $controller->getSubsectionsBlock(), // bloc des données chiffrées
			]
        );

        $content .= $this->getRender(Template::ADMINCHARACTER,$completeAttributes);
        return parent::getAdminContentPage($content);
    }

}