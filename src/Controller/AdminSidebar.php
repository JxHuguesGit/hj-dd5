<?php
namespace src\Controller;

use src\Constant\{Bootstrap, Constant, Field, Icon, Language, Template};
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\CharacterDraftRepository;
use src\Repository\RpgHeros as RepositoryRpgHeros;
use src\Service\Reader\CharacterDraftReader;
use src\Utils\Session;
use src\Utils\UrlGenerator;

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
            !in_array($this->currentTab, $this->allowedTabs)||$this->currentTab=='home' ? Constant::CST_ACTIVE : '',
            $strSidebarMenuItems
        ];
        return $this->getRender(Template::ADMINSIDEBAR, $attributes);
    }

    private function getCharacterItem(): string
    {
        // On a toujours des enfants. Potentiellement, aucun héros, mais a minima le lien pour en créer un.
        $strChildren = '<ul class="nav nav-treeview">';
        $url = UrlGenerator::admin(Constant::ONG_CHARACTER, '%d', '', '', ['step'=>'%s']);
        $blnActiveTab = $this->currentTab==Constant::ONG_CHARACTER;

        $attributes = [
            '',
            sprintf($url, 0, 'name'),
            $blnActiveTab && $this->currentId==0 ? Constant::CST_ACTIVE : '',
            Icon::IPLUS,
            'Nouveau',
            Bootstrap::CSS_DNONE,
            '',
            '', '',
        ];
        $strChildren .= $this->getRender(Template::ADMINSIDEBARITEM, $attributes);

        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $reader = new CharacterDraftReader(new CharacterDraftRepository($queryBuilder, $queryExecutor));
        $heroes = $reader->characterDraftByWpUser(Session::getWpUser()->data->ID);
        foreach ($heroes as $hero) {
            $id = $hero->id;
            $name = $hero->name;
            $parts = explode(' ', $name);
            $initiales = substr($parts[0], 0, 1).substr($parts[1]??'', 0, 1);
            $attributes = [
                '',
                sprintf($url, $id, $hero->createStep),
                $blnActiveTab && $this->currentId==$id ? Constant::CST_ACTIVE : '',
                'user',
                $name,
                Bootstrap::CSS_DNONE,
                '',
                '',
                $initiales,
            ];
            $strChildren .= $this->getRender(Template::ADMINSIDEBARITEM, $attributes);
        }

        $strChildren .= '</ul>';

        $attributes = [
            $blnActiveTab ? 'menu-open' : '',
            '#',
            $blnActiveTab ? Constant::CST_ACTIVE : '',
            'users',
            'Personnages',
            '',
            $strChildren,
            '', '',
        ];

        return $this->getRender(Template::ADMINSIDEBARITEM, $attributes);
    }

    private function getTimelineItem(): string
    {
        $attributes = [
            // la classe ne sera jamais menu-open puisque pas d'enfants.
            '',
            '/wp-admin/admin.php?page=hj-dd5%2Fadmin_manage.php&onglet=timeline',
            $this->currentTab=='timeline' ? Constant::CST_ACTIVE : '',
            'timeline',
            'Initiative',
            Bootstrap::CSS_DNONE,
            '',
            '', '',
        ];

        return $this->getRender(Template::ADMINSIDEBARITEM, $attributes);
    }

    private function getCompendiumItem(): string
    {
        // Liste des sous menus existants
        $children = [
            [Constant::CST_ID => Constant::WEAPONS,  Constant::CST_LABEL => Language::LG_WEAPONS_TITLE,  'icon' => Icon::IGAVEL],
            [Constant::CST_ID => Constant::ARMORS,   Constant::CST_LABEL => Language::LG_ARMORS_TITLE,   'icon' => Icon::ISHIELD],
            [Constant::CST_ID => Constant::SKILLS,   Constant::CST_LABEL => Language::LG_SKILLS_TITLE,   'icon' => Icon::IBRAIN],
            [Constant::CST_ID => Constant::FEATS,    Constant::CST_LABEL => Language::LG_FEATS_TITLE,    'icon' => Icon::IMEDAL],
            [Constant::CST_ID => Constant::CST_GEAR, Constant::CST_LABEL => Language::LG_GEAR_TITLE,     'icon' => Icon::IBOX],
            [Constant::CST_ID => Constant::MONSTERS, Constant::CST_LABEL => 'Monstres',    'icon' => Icon::IDRAGON],
            [Constant::CST_ID => Constant::ORIGINS,  Constant::CST_LABEL => Language::LG_HISTO_TITLE,  'icon' => Icon::ICOMPASS],
            [Constant::CST_ID => Constant::TOOLS,    Constant::CST_LABEL => Language::LG_TOOLS_TITLE,    'icon' => Icon::IGAVEL],
            [Constant::CST_ID => Constant::SPELLS,   Constant::CST_LABEL => Language::LG_SPELLS_TITLE,   'icon' => Icon::ISCROLL],
        ];

        // Construction du menu
        $strChildren = '<ul class="nav nav-treeview">';
        foreach ($children as $child) {
            $attributes = [
                '',
                '/wp-admin/admin.php?page=hj-dd5%2Fadmin_manage.php&onglet=compendium&id='.$child[Constant::CST_ID],
                $this->currentTab==Constant::ONG_COMPENDIUM && $this->currentId==$child[Constant::CST_ID] ? Constant::CST_ACTIVE : '',
                $child['icon'],
                $child[Constant::CST_LABEL],
                Bootstrap::CSS_DNONE,
                '',
                '', '',
            ];
            $strChildren .= $this->getRender(Template::ADMINSIDEBARITEM, $attributes);
        }
        $strChildren .= '</ul>';

        // Attribution au template
        $attributes = [
            $this->currentTab==Constant::ONG_COMPENDIUM ? 'menu-open' : '',
            '#',
            $this->currentTab==Constant::ONG_COMPENDIUM ? Constant::CST_ACTIVE : '',
            Icon::IBOOK,
            'Compendium',
            '',
            $strChildren,
            '', '',
        ];

        return $this->getRender(Template::ADMINSIDEBARITEM, $attributes);
    }
}
