<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Template;

class AdminCompendiumPage extends AdminPage
{
    
    public function getAdminContentPage(string $content=''): string
    {
        $currentId = $this->getArrParams('id');
        $paddingTop = 'padding-top:2rem;';

        switch ($currentId) {
            case Constant::ARMORS :
                $objTable = RpgArmor::getTable();
                $pageContent = $objTable?->display();
            break;
            case Constant::WEAPONS :
                $objTable = RpgWeapon::getTable($this->arrParams);
                $pageContent = $objTable?->display();
            break;
            case Constant::SKILLS :
                $objTable = RpgSkill::getTable($this->arrParams);
                $pageContent = $objTable?->display();
            break;
            case Constant::MONSTERS :
                $pageContent = RpgMonster::getAdminContentPage($this->arrParams);
            break;
            case Constant::FEATS :
                $pageContent = RpgFeat::getAdminContentPage($this->arrParams);
               break;
            case Constant::ORIGINS :
                $pageContent = RpgOrigin::getAdminContentPage($this->arrParams);
               break;
            case Constant::SPELLS :
                $pageContent = RpgSpell::getAdminContentPage($this->arrParams);
                $paddingTop = '';
               break;
            default :
                $objTable = null;
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
