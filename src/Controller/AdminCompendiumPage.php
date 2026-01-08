<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Page\PageArmorList;
use src\Page\PageWeaponList;
use src\Presenter\ArmorListPresenter;
use src\Presenter\RpgArmorTableBuilder;
use src\Presenter\RpgWeaponTableBuilder;
use src\Presenter\WeaponListPresenter;
use src\Repository\RpgArmor as RepositoryRpgArmor;
use src\Repository\RpgWeapon as RepositoryRpgWeapon;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;

class AdminCompendiumPage extends AdminPage
{
    
    public function getAdminContentPage(string $content=''): string
    {
        $currentId = $this->getArrParams('id');
        $paddingTop = 'padding-top:2rem;';

        switch ($currentId) {
            case Constant::ARMORS :
                $objDao = new RepositoryRpgArmor(new QueryBuilder(), new QueryExecutor());
                $armors = $objDao->findAllWithItemAndType([], [
                    Field::ARMORTYPID=>Constant::CST_ASC,
                    Field::ARMORCLASS=>Constant::CST_ASC,
                    Field::GOLDPRICE=>Constant::CST_ASC
                ]);

                $presenter = new ArmorListPresenter();
                $pageContent = $presenter->present($armors);
                $page = new PageArmorList(
                    new TemplateRenderer(),
                    new RpgArmorTableBuilder()
                );
                $pageContent = $page->renderAdmin($pageContent);
            break;
            case Constant::WEAPONS :
                $objDao = new RepositoryRpgWeapon(new QueryBuilder(), new QueryExecutor());
                $weapons = $objDao->findAllWithItemAndType([], [
                    Field::WPNCATID=>Constant::CST_ASC,
                    Field::WPNRANGEID=>Constant::CST_ASC,
                    'i.name'=>Constant::CST_ASC,
                ]);

                $presenter = new WeaponListPresenter();
                $pageContent = $presenter->present($weapons);
                $page = new PageWeaponList(
                    new TemplateRenderer(),
                    new RpgWeaponTableBuilder()
                );
                $pageContent = $page->renderAdmin($pageContent);
            break;
            case Constant::SKILLS :
                $objTable = RpgSkill::getTable($this->arrParams);
                $pageContent = $objTable?->display();
            break;
            case Constant::MONSTERS :
                $pageContent = RpgMonster::getAdminContentPage($this->arrParams);
                $paddingTop = '';
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
