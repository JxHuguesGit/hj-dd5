<?php
namespace src\Controller;

use src\Constant\Icon;
use src\Constant\Template;

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
    	$strChildren = '<ul class="nav nav-treeview">';
        
    	$attributes = [
        	'',
            '/wp-admin/admin.php?page=hj-dd5%2Fadmin_manage.php&onglet=character&id=1',
        	$this->currentTab=='character' && $this->currentId==1 ? 'active' : '',
            'circle',
            'Sheila',
            'd-none',
            '',
        ];
        $strChildren .= $this->getRender(Template::ADMINSIDEBARITEM, $attributes);
        
    	$attributes = [
        	'',
            '/wp-admin/admin.php?page=hj-dd5%2Fadmin_manage.php&onglet=character&id=2',
        	$this->currentTab=='character' && $this->currentId==2 ? 'active' : '',
            'circle',
            'PJ2',
            'd-none',
            '',
        ];
        $strChildren .= $this->getRender(Template::ADMINSIDEBARITEM, $attributes);
        
    	$attributes = [
        	'',
            '/wp-admin/admin.php?page=hj-dd5%2Fadmin_manage.php&onglet=character&id=3',
        	$this->currentTab=='character' && $this->currentId==3 ? 'active' : '',
            'circle',
            'PJ3',
            'd-none',
            '',
        ];
        $strChildren .= $this->getRender(Template::ADMINSIDEBARITEM, $attributes);

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
            ['id' => 'armors', 'label' => 'Armures', 'icon' => Icon::ISHIELD],
            ['id' => 'weapons', 'label' => 'Armes', 'icon' => Icon::IGAVEL],
            ['id' => 'skills', 'label' => 'Compétences', 'icon' => Icon::IBRAIN],
            ['id' => 'feats', 'label' => 'Dons', 'icon' => Icon::IMEDAL],
            ['id' => 'spells', 'label' => 'Sorts', 'icon' => Icon::ISCROLL],
            ['id' => 'monsters', 'label' => 'Monstres', 'icon' => Icon::IDRAGON],
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