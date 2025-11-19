<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Icon;
use src\Constant\Template;
use src\Repository\RpgHeros as RepositoryRpgHeros;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Utils\Session;

class AdminSidebar extends Utilities
{
    private array $allowedTabs;
    private string $currentTab;
    private string $currentId;
    
    public function setAttributes(array $allowedTabs, string $currentTab='', string $currentId='')
    {
        $this->allowedTabs = $allowedTabs;
        $this->currentTab = $currentTab;
        $this->currentId = $currentId;
    }
    
    public function getContent(): string
    {
        $strSidebarMenuItems = '';
        // On ajoute le menu "Character";
        $strSidebarMenuItems .= $this->getCharacterItem();
        // On ajoute le menu "Initiative";
        $strSidebarMenuItems .= $this->getTimelineItem();
        // On ajoute le menu "Compendium";
        $strSidebarMenuItems .= $this->getCompendiumItem();
        
        $attributes = [
            !in_array($this->currentTab, $this->allowedTabs)||$this->currentTab=='home' ? 'active' : '',
            $strSidebarMenuItems
        ];
        return $this->getRender(Template::ADMINSIDEBAR, $attributes);
    }
    
    private function getCharacterItem(): string
    {
        // On a toujours des enfants. Potentiellement, aucun héros, mais a minima le lien pour en créer un.
        $strChildren = '<ul class="nav nav-treeview">';
        $attributes = [
            '',
            '/wp-admin/admin.php?page=hj-dd5%2Fadmin_manage.php&onglet=character&id=0&step=name',
            $this->currentTab=='character' && $this->currentId==0 ? 'active' : '',
            'plus',
            'Nouveau',
            'd-none',
            '',
        ];
        $strChildren .= $this->getRender(Template::ADMINSIDEBARITEM, $attributes);
        // TODO : Gérer un nombre excessif de personnages ?
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDaoHeros = new RepositoryRpgHeros($queryBuilder, $queryExecutor);
        $rpgHeros = $objDaoHeros->findBy([Field::WPUSERID=>Session::getWpUser()->data->ID]);
        $rpgHeros->rewind();
        while ($rpgHeros->valid()) {
            $rpgHero = $rpgHeros->current();
            $id = $rpgHero->getField(Field::ID);
            $attributes = [
                '',
                '/wp-admin/admin.php?page=hj-dd5%2Fadmin_manage.php&onglet=character&id='.$id.'&step='.$rpgHero->getField(Field::CREATESTEP),
                $this->currentTab=='character' && $this->currentId==$id ? 'active' : '',
                'user',
                $rpgHero->getField(Field::NAME),
                'd-none',
                '',
            ];
            $strChildren .= $this->getRender(Template::ADMINSIDEBARITEM, $attributes);
            $rpgHeros->next();
        }
        
        $strChildren .= '</ul>';
        
        $attributes = [
            $this->currentTab=='character' ? 'menu-open' : '',
            '#',
            $this->currentTab=='character' ? 'active' : '',
            'users',
            'Personnages',
            '',
            $strChildren,
        ];
        
        return $this->getRender(Template::ADMINSIDEBARITEM, $attributes);
    }
    
    private function getTimelineItem(): string
    {
        $attributes = [
            '',// la classe ne sera jamais menu-open puisque pas d'enfants.
            '/wp-admin/admin.php?page=hj-dd5%2Fadmin_manage.php&onglet=timeline',
            $this->currentTab=='timeline' ? 'active' : '',
            'timeline',
            'Initiative',
            'd-none',
            '',
        ];
        
        return $this->getRender(Template::ADMINSIDEBARITEM, $attributes);
    }

    private function getCompendiumItem(): string
    {
        // Liste des sous menus existants
        $children = [
            ['id' => Constant::ARMORS, 'label' => 'Armures', 'icon' => Icon::ISHIELD],
            ['id' => Constant::WEAPONS, 'label' => 'Armes', 'icon' => Icon::IGAVEL],
            ['id' => Constant::SKILLS, 'label' => 'Compétences', 'icon' => Icon::IBRAIN],
            ['id' => Constant::FEATS, 'label' => 'Dons', 'icon' => Icon::IMEDAL],
            ['id' => Constant::MONSTERS, 'label' => 'Monstres', 'icon' => Icon::IDRAGON],
            ['id' => Constant::ORIGINS, 'label' => 'Origines', 'icon' => Icon::ICOMPASS],
            ['id' => Constant::SPELLS, 'label' => 'Sorts', 'icon' => Icon::ISCROLL],
        ];

        // Construction du menu
        $strChildren = '<ul class="nav nav-treeview">';
        foreach ($children as $child) {
            $attributes = [
                '',
                '/wp-admin/admin.php?page=hj-dd5%2Fadmin_manage.php&onglet=compendium&id='.$child['id'],
                $this->currentTab=='compendium' && $this->currentId==$child['id'] ? 'active' : '',
                $child['icon'],
                $child['label'],
                'd-none',
                '',
            ];
            $strChildren .= $this->getRender(Template::ADMINSIDEBARITEM, $attributes);
        }
        $strChildren .= '</ul>';
        
        // Attribution au template
        $attributes = [
            $this->currentTab=='compendium' ? 'menu-open' : '',
            '#',
            $this->currentTab=='compendium' ? 'active' : '',
            Icon::IBOOK,
            'Compendium',
            '',
            $strChildren,
        ];
        
        return $this->getRender(Template::ADMINSIDEBARITEM, $attributes);
    }
}
