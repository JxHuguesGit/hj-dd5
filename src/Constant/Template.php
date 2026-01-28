<?php
namespace src\Constant;

final class Template
{
    public const ASSETS_PATH         = 'assets/';
    public const HTML_PATH           = self::ASSETS_PATH . 'html/';
    public const LOGS_PATH           = self::ASSETS_PATH . 'logs/';

    public const SRC_PATH            = 'src/';

    public const TEMPLATE_PATH       = 'templates/';

    public const BASE                = self::TEMPLATE_PATH.'base.tpl';
    public const FOOTER              = self::TEMPLATE_PATH.'footer.tpl';
    public const HEADER              = self::TEMPLATE_PATH.'header.tpl';
    public const LOCAL_CSS           = self::TEMPLATE_PATH.'localCss.tpl';
    public const LOCAL_JS            = self::TEMPLATE_PATH.'localJs.tpl';
    public const WWW_CSS             = self::TEMPLATE_PATH.'wwwCss.tpl';
    public const WWW_JS              = self::TEMPLATE_PATH.'wwwJs.tpl';

    public const ADMIN_PATH          = self::TEMPLATE_PATH.'admin/';
    public const ADMINBASE           = self::ADMIN_PATH.'adminBase.tpl';
    public const ADMINSIDEBAR        = self::ADMIN_PATH.'adminSidebar.tpl';
    public const ADMINSIDEBARITEM    = self::ADMIN_PATH.'adminSidebarItem.tpl';
    
    public const ADMINCHARACTER      = self::ADMIN_PATH.'adminCharacter.tpl';
    public const ADMINQUICKINFO      = self::ADMIN_PATH.'adminCharacterQuickInfo.tpl';
    public const ADMINCHARABILITY    = self::ADMIN_PATH.'adminCharacterAbility.tpl';
    public const ADMINCHARPROFBONUS  = self::ADMIN_PATH.'adminCharacterQuickInfoProfBonus.tpl';
    public const ADMINCHARSPEED      = self::ADMIN_PATH.'adminCharacterQuickInfoSpeed.tpl';
    public const ADMINCHARHEROICINS  = self::ADMIN_PATH.'adminCharacterQuickInfoHeroicInspiration.tpl';
    public const ADMINCHARSUBSECTION = self::ADMIN_PATH.'adminCharacterSubsections.tpl';
    public const ADMINCHARSUBSECABIL = self::ADMIN_PATH.'adminCharacterSubsectionAbilities.tpl';
    public const ADMINCHARSUBSECABY  = self::ADMIN_PATH.'adminCharacterSubsectionAbility.tpl';
    public const ADMINCHARSUBSECCBT  = self::ADMIN_PATH.'adminCharacterSubsectionCombat.tpl';
    public const ADMINCHARSUBSECSKLS = self::ADMIN_PATH.'adminCharacterSubsectionSkills.tpl';
    public const ADMINCHARSUBSECSKL  = self::ADMIN_PATH.'adminCharacterSubsectionSkill.tpl';
    public const ADMINCHARSUBSECPSV  = self::ADMIN_PATH.'adminCharacterSubsectionPassive.tpl';
    public const ADMINCHARSUBSECMLG  = self::ADMIN_PATH.'adminCharacterSubsectionMaterielLangue.tpl';
    
    public const ADMINCOMPENDIUM     = self::ADMIN_PATH.'adminCompendium.tpl';

    public const CARD_PATH           = self::TEMPLATE_PATH.'card/';
    public const FEAT_CARD           = self::CARD_PATH.'featCard.tpl';
    public const MONSTER_CARD        = self::CARD_PATH.'monsterCard.tpl';
    public const NOT_FOUND_CARD      = self::CARD_PATH.'notFoundCard.tpl';
    public const SPELL_CARD          = self::CARD_PATH.'spellCard.tpl';
    public const SPELL_DETAIL_CARD   = self::CARD_PATH.'spellDetailCard.tpl';
    public const FEAT_DETAIL_CARD    = self::CARD_PATH.'featDetailCard.tpl';
    public const ORIGIN_CARD         = self::CARD_PATH.'origineCard.tpl';
    public const ORIGIN_DETAIL_CARD  = self::CARD_PATH.'origineDetailCard.tpl';
    public const SPECIE_DETAIL_CARD  = self::CARD_PATH.'specieDetailCard.tpl';
    public const SPECIES_POWER_CARD  = self::CARD_PATH.'speciesPowerCard.tpl';

    public const CASTE_PATH          = self::TEMPLATE_PATH.'caste/';
    public const CASTE_DETAIL_GEN    = self::CASTE_PATH.'casteDetailGenerique.tpl';
    public const CASTE_DETAIL_CLE    = self::CASTE_PATH.'casteDetailCLE.tpl';
    public const CASTE_DETAIL_FIG    = self::CASTE_PATH.'casteDetailFIG.tpl';
    public const CASTE_DETAIL_ROG    = self::CASTE_PATH.'casteDetailROG.tpl';
    public const CASTE_DETAIL_WIZ    = self::CASTE_PATH.'casteDetailWIZ.tpl';
    
    public const FORM_PATH           = self::TEMPLATE_PATH.'form/';
    public const FILTER_MONSTER      = self::FORM_PATH.'monsterFilter.tpl';
    public const FILTER_SPELL        = self::FORM_PATH.'spellFilter.tpl';
    public const FORM_FEAT           = self::FORM_PATH.'RpgFeat.tpl';
    public const FORM_MONSTERABILITY = self::FORM_PATH.'RpgMonster.tpl';

    public const HERO_PATH           = self::TEMPLATE_PATH.'hero/';
    public const HERO_CREATE_HEADER  = self::HERO_PATH.'createHeader.tpl';
    public const HERO_CREATE_FORM    = self::HERO_PATH.'createForm.tpl';

    public const PUBLIC_PATH         = self::TEMPLATE_PATH.'public/';
    public const MAIN_PAGE           = self::PUBLIC_PATH.'main.tpl';
    public const HOME_PAGE           = self::PUBLIC_PATH.'home.tpl';
    public const DETAIL_PAGE         = self::PUBLIC_PATH.'detail.tpl';
    public const CATEGORY_PAGE       = self::PUBLIC_PATH.'category.tpl';

    public const WIP_PAGE            = self::PUBLIC_PATH.'wip.tpl';
    public const NOT_FOUND           = self::PUBLIC_PATH.'wip.tpl';

    public const UTILITIES_PATH      = self::TEMPLATE_PATH.'utilities/';
    public const CASTE_SELECT_BTN    = self::UTILITIES_PATH.'casteSelectionButton.tpl';
    public const HERO_SELECTION_LINE = self::UTILITIES_PATH.'heroSelectionLine.tpl';
    
    public const CREATE_PATH         = self::TEMPLATE_PATH.'creation/';
    public const CREATE_CLASSE       = self::CREATE_PATH.'step-classe.tpl';
    public const CREATE_NAME         = self::CREATE_PATH.'step-name.tpl';
    public const CREATE_ORIGIN       = self::CREATE_PATH.'step-origin.tpl';
    public const CREATE_SPECIES      = self::CREATE_PATH.'step-species.tpl';
    public const CREATE_FEAT         = self::CREATE_PATH.'step-feat.tpl';
    public const CREATE_SKILLTOOL    = self::CREATE_PATH.'step-skillTool.tpl';
    public const CREATE_SIDEBAR      = self::CREATE_PATH.'step-sidebar.tpl';

    public const MODAL_PATH          = self::TEMPLATE_PATH.'modal/';
    public const MAIN_MODAL          = self::MODAL_PATH.'modal.tpl';
    public const SPELL_FILTER_MODAL  = self::MODAL_PATH.'spellFilter.tpl';

}
