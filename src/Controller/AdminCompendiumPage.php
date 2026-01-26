<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Template;
use src\Controller\Compendium\ArmorCompendiumHandler;
use src\Controller\Compendium\FeatCompendiumHandler;
use src\Controller\Compendium\SkillCompendiumHandler;
use src\Controller\Compendium\WeaponCompendiumHandler;

class AdminCompendiumPage extends AdminPage
{
    
    public function getAdminContentPage(string $content=''): string
    {
        $currentId = $this->getArrParams('id');
        $paddingTop = 'padding-top:2rem;';

        switch ($currentId) {
            case Constant::ARMORS :
                $pageContent = (new ArmorCompendiumHandler())->render();
            break;
            case Constant::WEAPONS :
                $pageContent = (new WeaponCompendiumHandler())->render();
            break;
            case Constant::SKILLS :
                $pageContent = (new SkillCompendiumHandler())->render();
            break;
            case Constant::MONSTERS :
                $pageContent = RpgMonster::getAdminContentPage($this->arrParams);
                $paddingTop = '';
            break;
            case Constant::FEATS :
                $pageContent = (new FeatCompendiumHandler())->render();
               break;
            case Constant::ORIGINS :
                $pageContent = RpgOrigin::getAdminContentPage($this->arrParams);
               break;
            case Constant::SPELLS :
                $pageContent = RpgSpell::getAdminContentPage($this->arrParams);
                $paddingTop = '';
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
