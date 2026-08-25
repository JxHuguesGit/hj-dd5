<?php
namespace src\Constant;

class Bootstrap
{
    public const AUTO      = 'auto';
    public const BADGE     = 'badge';
    public const BG        = 'bg';
    public const BTN       = 'btn';
    public const CENTER    = 'center';
    public const DARK      = 'dark';
    public const DANGER    = 'danger';
    public const DNONE     = 'd-none';
    public const END       = 'end';
    public const FONT      = 'font';
    public const ITEM      = 'item';
    public const ITALIC    = 'italic';
    public const LINK      = 'link';
    public const MB3       = 'mb-3';
    public const MENU_OPEN = 'menu-open';
    public const MT5       = 'mt-5';
    public const MX        = 'mx';
    public const MY        = 'my';
    public const NAV       = 'nav';
    public const NOWRAP    = 'nowrap';
    public const OUTLINE   = 'outline';
    public const SM        = 'sm';
    public const STRIPED   = 'striped';
    public const TABLE     = 'table';
    public const TEXT      = 'text';
    public const TITLE     = 'title';
    public const TREEVIEW  = 'treeview';
    public const WHITE     = 'white';

    public const FEAT         = 'feat';
    public const SKILL        = 'skill';
    public const SPECIE       = 'specie';
    public const GROUPS       = 'groups';
    public const GRID         = 'grid';
    public const LIST         = 'list';
    public const GROUP        = 'group';
    public const CARD         = 'card';
    public const ORIGIN       = 'origin';
    public const ORIGINS      = 'origins';
    public const SPELL        = 'spell';
    public const SUBSKILL     = 'subskill';
    public const SUBSKILLS    = 'subskills';
    public const DATA         = 'data';
    public const INFO         = 'info';
    public const INFOS        = 'infos';
    public const DETAIL       = 'detail';
    public const ABILITY      = 'ability';
    public const NAVIGATION   = 'navigation';

    public const FLOAT_START = 'float-start';

    public const DATA_CARD        = self::DATA . '-' . self::CARD;
    public const DATA_GRID        = self::DATA . '-' . self::GRID;
    public const DATA_GROUP       = self::DATA . '-' . self::GROUP;
    public const DATA_LIST        = self::DATA . '-' . self::LIST;
    public const DATA_GROUP_TITLE = self::DATA_GROUP . '-' . self::TITLE;

    public const DATA_DETAIL      = self::DATA . '-' . self::DETAIL;
    public const DATA_DETAIL_HEADER = self::DATA . '-' . self::DETAIL . '-header';
    public const DATA_DETAIL_NAVIGATION = self::DATA . '-' . self::DETAIL . '-navigation';
    public const DATA_DETAIL_DESCRIPTION = self::DATA . '-' . self::DETAIL . '-description';
    public const DATA_DETAIL_INFO = 'data-detail-info';
    public const DATA_DETAIL_INFOS = 'data-detail-infos';
    public const GEAR_DETAIL_INFOS = 'gear-detail-infos';
    public const GEAR_DETAIL_DESCRIPTION = 'gear-detail-description';
    public const GEAR_DETAIL_INFO = 'gear-detail-info';
    public const GEAR_DETAIL_INFO_VALUE = 'gear-detail-info-value';
    
    public const ABILITY_DESCRIPTION = 'ability-description';
    public const ABILITY_TITLE = 'ability-title';
    public const ABILITY_CHILDREN = 'ability-children';
    public const ABILITY_OPTIONS = 'ability-options';
    public const FEAT_GROUPS  = self::FEAT . '-' . self::GROUPS;
    public const FEAT_GRID    = self::FEAT . '-' . self::GRID;
    public const FEAT_ORIGIN  = self::FEAT . '-' . self::ORIGIN;
    public const FEAT_ORIGINS = self::FEAT . '-' . self::ORIGINS;
    public const FEAT_GROUP   = self::FEAT . '-' . self::GROUP;
    public const FEAT_CARD   = self::FEAT . '-' . self::CARD;
    public const FEAT_GROUP_TITLE = self::FEAT . '-' . self::GROUP . '-' . self::TITLE;
    public const FEAT_PREREQUIS = 'feat-prerequisite';
    public const SKILL_DETAIL   = self::SKILL . '-' . self::DETAIL;
    public const SKILL_ABILITY = self::SKILL . '-ability';
    public const SKILL_SUBSKILLS = self::SKILL . '-' . self::SUBSKILLS;
    public const SKILL_GROUPS = self::SKILL . '-' . self::GROUPS;
    public const SKILL_ORIGINS = self::SKILL . '-' . self::ORIGINS;
    public const SKILL_GRID   = self::SKILL . '-' . self::GRID;
    public const SKILL_GROUP  = self::SKILL . '-' . self::GROUP;
    public const SKILL_CARD   = self::SKILL . '-' . self::CARD;
    public const SKILL_GROUP_TITLE = self::SKILL . '-' . self::GROUP . '-' . self::TITLE;
    public const SPECIE_GROUPS  = self::SPECIE . '-' . self::GROUPS;
    public const SPECIE_GRID    = self::SPECIE . '-' . self::GRID;
    public const SPECIE_GROUP   = self::SPECIE . '-' . self::GROUP;
    public const SPECIE_PROPERTIES  = self::SPECIE . '-properties';
    public const SPECIE_DESCRIPTION = self::SPECIE . '-description';
    public const SPECIE_ABILITIES  = self::SPECIE . '-abilities';
    public const SPECIE_CARD   = self::SPECIE . '-' . self::CARD;
    public const SPECIE_GROUP_TITLE = self::SPECIE . '-' . self::GROUP . '-' . self::TITLE;
    public const ORIGIN_GROUPS  = self::ORIGIN . '-' . self::GROUPS;
    public const ORIGIN_GRID    = self::ORIGIN . '-' . self::GRID;
    public const ORIGIN_GROUP   = self::ORIGIN . '-' . self::GROUP;
    public const ORIGIN_CARD   = self::ORIGIN . '-' . self::CARD;
    public const ORIGIN_DESCRIPTION = 'origin-description';
    public const ORIGIN_PROPERTY = 'origin-property';
    public const ORIGIN_EQUIPMENT = 'origin-equipment';
    public const ORIGIN_PROPERTIES = 'origin-properties';
    public const ORIGIN_GROUP_TITLE = self::ORIGIN . '-' . self::GROUP . '-' . self::TITLE;
    public const SPELL_GROUPS  = self::SPELL . '-' . self::GROUPS;
    public const SPELL_GRID    = self::SPELL . '-' . self::GRID;
    public const SPELL_LIST    = self::SPELL . '-' . self::LIST;
    public const SPELL_GROUP   = self::SPELL . '-' . self::GROUP;
    public const SPELL_CARD   = self::SPELL . '-' . self::CARD;
    public const SPELL_GROUP_TITLE = self::SPELL . '-' . self::GROUP . '-' . self::TITLE;
    public const SPELL_DETAIL_DESCRIPTION   = self::SPELL . '-detail-description';
    public const SPELL_DETAIL   = self::SPELL . '-' . self::DETAIL;
    public const SPELL_DETAIL_INFO   = self::SPELL . '-' . self::DETAIL . '-' . self::INFO;
    public const SPELL_DETAIL_NAVIGATION   = self::SPELL . '-' . self::DETAIL . '-' . self::NAVIGATION;
    public const TOOL_TYPE = 'tool-type';
    public const TOOL_DETAIL_DESCRIPTION = 'tool-detail-description';
    public const TOOL_DETAIL_CRAFT_ITEM_VALUE = 'tool-detail-craftable-items-value';
    public const TOOL_DETAIL_CRAFT_ITEMS = 'tool-detail-craftable-items';
    public const TOOL_DETAIL_ORIGINS_VALUE = 'tool-detail-origins-value';
    public const TOOL_DETAIL_ORIGINS = 'tool-detail-origins';
    public const TOOL_CARD_ORIGINS_LABEL = 'tool-card-origins-label';
    public const TOOL_CARD_WEIGHT = 'tool-card-weight';
    public const TOOL_CARD_ORIGINS = 'tool-card-origins';
    public const TOOL_CARD_PRICE = 'tool-card-price';
    public const ITEM_CATEGORY_GRID = 'item-category-grid';

    public const ARMOR = 'armor';
    public const ARMOR_GRID = self::ARMOR . '-' . self::GRID;
    public const ARMOR_GROUP = self::ARMOR . '-' . self::GROUP;
    public const ARMOR_CARD = self::ARMOR . '-' . self::CARD;
    public const ARMOR_LIST    = self::ARMOR . '-' . self::LIST;
    public const ARMOR_DETAIL   = self::ARMOR . '-' . self::DETAIL;
    public const ARMOR_DETAIL_INFO   = self::ARMOR . '-' . self::DETAIL . '-' . self::INFO;
    public const ARMOR_DETAIL_INFOS  = self::ARMOR . '-' . self::DETAIL . '-' . self::INFOS;
    public const ARMOR_DETAIL_NAVIGATION   = self::ARMOR . '-' . self::DETAIL . '-' . self::NAVIGATION;

    public const WEAPON = 'weapon';
    public const WEAPON_GRID = self::WEAPON . '-' . self::GRID;
    public const WEAPON_GROUP = self::WEAPON . '-' . self::GROUP;
    public const WEAPON_CARD = self::WEAPON . '-' . self::CARD;
    public const WEAPON_CARD_INFO   = self::WEAPON . '-card-info';
    public const WEAPON_LIST    = self::WEAPON . '-' . self::LIST;
    public const WEAPON_DETAIL   = self::WEAPON . '-' . self::DETAIL;
    public const WEAPON_DETAIL_INFO   = self::WEAPON . '-' . self::DETAIL . '-' . self::INFO;
    public const WEAPON_DETAIL_INFO_VALUE = self::WEAPON . '-detail-info-value';
    public const WEAPON_DETAIL_INFOS  = self::WEAPON . '-' . self::DETAIL . '-' . self::INFOS;
    public const WEAPON_DETAIL_NAVIGATION   = self::WEAPON . '-' . self::DETAIL . '-' . self::NAVIGATION;

    public const TOOL = 'tool';
    public const TOOL_GRID = self::TOOL . '-' . self::GRID;
    public const TOOL_GROUP = self::TOOL . '-' . self::GROUP;
    public const TOOL_CARD = self::TOOL . '-' . self::CARD;
    public const TOOL_CARD_INFOS = self::TOOL . '-' . self::CARD . '-infos';
    public const TOOL_LIST    = self::TOOL . '-' . self::LIST;
    public const TOOL_DETAIL   = self::TOOL . '-' . self::DETAIL;
    public const TOOL_DETAIL_INFO   = self::TOOL . '-' . self::DETAIL . '-' . self::INFO;
    public const TOOL_DETAIL_INFO_VALUE = self::TOOL . '-detail-info-value';
    public const TOOL_DETAIL_INFOS  = self::TOOL . '-' . self::DETAIL . '-' . self::INFOS;
    public const TOOL_DETAIL_NAVIGATION   = self::TOOL . '-' . self::DETAIL . '-' . self::NAVIGATION;

    public const GEAR = 'gear';
    public const GEAR_GRID = self::GEAR . '-' . self::GRID;
    public const GEAR_CARD = self::GEAR . '-' . self::CARD;


    public const ROW_DARK_STRIPED = 'row-dark-striped';

    public const COL_1     = 'col-1';
    public const COL_2     = 'col-2';
    public const COL_6     = 'col-6';
    public const COL_12    = 'col-12';
    public const COL_MD_2  = 'col-md-2';
    public const COL_MD_3  = 'col-md-3';
    public const COL_MD_4  = 'col-md-4';
    public const COL_MD_5  = 'col-md-5';
    public const COL_MD_8  = 'col-md-8';
    public const COL_MD_12 = 'col-md-12';

    public const MX_AUTO = self::MX . '-' . self::AUTO;
    public const MY4     = self::MY . '-4';

    public const NAV_ITEM       = self::NAV . '-' . self::ITEM;
    public const NAV_LINK       = self::NAV . '-' . self::LINK;
    public const NAV_LINK_TITLE = self::NAV . '-' . self::LINK . '-' . self::TITLE;
    public const NAV_TREEVIEW   = self::NAV . '-' . self::TREEVIEW;

    public const FONT_ITALIC = self::FONT . '-' . self::ITALIC;

    public const TABLE_DARK    = self::TABLE . '-' . self::DARK;
    public const TABLE_SM      = self::TABLE . '-' . self::SM;
    public const TABLE_STRIPED = self::TABLE . '-' . self::STRIPED;

    public const TEXT_CENTER = self::TEXT . '-' . self::CENTER;
    public const TEXT_DANGER = self::TEXT . '-' . self::DANGER;
    public const TEXT_DARK   = self::TEXT . '-' . self::DARK;
    public const TEXT_END    = self::TEXT . '-' . self::END;
    public const TEXT_NOWRAP = self::TEXT . '-' . self::NOWRAP;
    public const TEXT_WHITE  = self::TEXT . '-' . self::WHITE;

    public const BG_DARK = self::TEXT . '-' . self::BG . '-' . self::DARK;

    public const BTN_OUTLINE_DARK = self::BTN . '-' . self::OUTLINE . '-' . self::DARK;
    public const BTN_SM           = self::BTN . '-' . self::SM;

    public const WITH_MRGNTOP = 'withMarginTop';
}
