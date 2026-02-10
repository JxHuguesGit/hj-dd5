<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Template;
use src\Controller\Compendium\ArmorCompendiumHandler;
use src\Controller\Compendium\FeatCompendiumHandler;
use src\Controller\Compendium\GearCompendiumHandler;
use src\Controller\Compendium\OriginCompendiumHandler;
use src\Controller\Compendium\SkillCompendiumHandler;
use src\Controller\Compendium\SpellCompendiumHandler;
use src\Controller\Compendium\ToolCompendiumHandler;
use src\Controller\Compendium\WeaponCompendiumHandler;
use src\Presenter\ToastBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\FeatRepository;
use src\Repository\ItemRepository;
use src\Repository\OriginRepository;
use src\Service\Reader\FeatReader;
use src\Service\Reader\ItemReader;
use src\Service\Reader\OriginReader;

class AdminCompendiumPage extends AdminPage
{
    
    public function getAdminContentPage(string $content=''): string
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $templateRender = new TemplateRenderer();
        $currentId = $this->getArrParams('id');
        $paddingTop = 'padding-top:112px;';

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
            case Constant::CST_GEAR :
                $itemRepository = new ItemRepository($qb, $qe);
                $pageContent = (new GearCompendiumHandler(
                    $itemRepository,
                    new ItemReader($itemRepository),
                    new ToastBuilder($templateRender),
                    $templateRender
                ))->render();
            break;
            case Constant::MONSTERS :
                $pageContent = RpgMonster::getAdminContentPage($this->arrParams);
                $paddingTop = '';
            break;
            case Constant::FEATS :
                $featRepository = new FeatRepository($qb, $qe);
                $pageContent = (new FeatCompendiumHandler(
                    $featRepository,
                    new FeatReader($featRepository),
                    new OriginReader(new OriginRepository($qb, $qe)),
                    new ToastBuilder($templateRender),
                    $templateRender
                ))->render();
               break;
            case Constant::ORIGINS :
                $pageContent = (new OriginCompendiumHandler())->render();
               break;
            case Constant::TOOLS :
                $pageContent = (new ToolCompendiumHandler())->render();
            break;
            case Constant::SPELLS :
                $pageContent = (new SpellCompendiumHandler())->render();
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
