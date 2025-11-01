<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\RpgAlignement as EntityRpgAlignement;
use src\Entity\RpgMonster as EntityRpgMonster;
use src\Entity\RpgReference as EntityRpgReference;
use src\Entity\RpgSousTypeMonstre as EntityRpgSousTypeMonstre;
use src\Entity\RpgTypeMonstre as EntityRpgTypeMonstre;
use src\Helper\SizeHelper;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgAlignement;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgReference;
use src\Repository\RpgSousTypeMonstre;
use src\Repository\RpgTypeMonstre;
use src\Utils\Table;

class AdminCompendiumPage extends AdminPage
{
    private string $bgColor = '';
    private string $fontColor = '';
    private array $defaultColor = [];
    
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
            $pageContent,//$this->getBlockQuickInfo(), // bloc des données chiffrées
            $paddingTop,
            /*
            '-large',//$hero->getId(), // id du personnage
            '',//$scheme, // style couleur (qui va définir les contours et fonds des svg mais aussi la couleur du texte)
            '',//'/wp-cotent/plugins/hj-dd5/assets/images/PJ1avatar.jpeg', // image du personnage
            '',//'Sheilas', // nom du personnage
            '',//'Humaine', // espèce du personnage
            '',//'Roublard 1', // classe du personnage
            '',//'Niveau 1', // niveau du personnage
            '',//$this->getBlockSubsections(), // bloc des données chiffrées
            */
        ];

        $content .= $this->getRender(Template::ADMINCOMPENDIUM, $attributes);
        return parent::getAdminContentPage($content);
    }

}
