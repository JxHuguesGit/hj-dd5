<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Template;
use src\Factory\CompendiumFactory;

class AdminCompendiumPage extends AdminPage
{
    public function __construct(
        private array $uri,
        private CompendiumFactory $compendiumFactory
    ) {
        parent::__construct($this->uri);
    }
    
    public function getAdminContentPage(string $content=''): string
    {
        $currentId = $this->getArrParams('id');
        $paddingTop = 'padding-top:112px;';

        switch ($currentId) {
            case Constant::ARMORS :
                $pageContent = $this->compendiumFactory->armor()->render();
            break;
            case Constant::WEAPONS :
                $pageContent = $this->compendiumFactory->weapon()->render();
            break;
            case Constant::SKILLS :
                $pageContent = $this->compendiumFactory->skill()->render();
            break;
            case Constant::CST_GEAR :
                $pageContent = $this->compendiumFactory->gear()->render();
            break;
            case Constant::MONSTERS :
                $pageContent = RpgMonster::getAdminContentPage($this->arrParams);
                $paddingTop = '';
            break;
            case Constant::FEATS :
                $pageContent = $this->compendiumFactory->feat()->render();
               break;
            case Constant::ORIGINS :
                $pageContent = $this->compendiumFactory->origin()->render();
               break;
            case Constant::TOOLS :
                $pageContent = $this->compendiumFactory->tool()->render();
            break;
            case Constant::SPELLS :
                $pageContent = $this->compendiumFactory->spell()->render();
               break;
            default :
                $pageContent = '';
            break;
        }
        
        // Dans cette méthode, on gère l'entête, le cadre noir : Image, couleurs, nom, espèce, classe, niveau
        // Tout le reste sera géré via d'autres méthodes afin de ne pas être perdu dans le nombre de paramètres du template
        $attributes = [
            $pageContent,
            $paddingTop,
        ];
        $content .= $this->getRender(Template::ADMINCOMPENDIUM, $attributes);
        return parent::getAdminContentPage($content);
    }

}
