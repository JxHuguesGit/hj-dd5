<?php
namespace src\Constant;

use src\Constant\Language as L;
class Bootstrap
{
    public const AUTO      = 'auto';
    public const BADGE     = 'badge';
    public const BG        = 'bg';
    public const BORDER    = 'border';
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
    public const START     = 'start';
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

    public const FLOAT_START = 'float-' . self::START;

    public const DATA_CARD        = self::DATA . L::DASH . self::CARD;
    public const DATA_GRID        = self::DATA . L::DASH . self::GRID;
    public const DATA_GROUP       = self::DATA . L::DASH . self::GROUP;
    public const DATA_LIST        = self::DATA . L::DASH . self::LIST;
    public const DATA_GROUP_TITLE = self::DATA_GROUP . L::DASH . self::TITLE;

    public const DATA_DETAIL      = self::DATA . L::DASH . self::DETAIL;
    public const DATA_DETAIL_HEADER = self::DATA . L::DASH . self::DETAIL . '-header';
    public const DATA_DETAIL_NAVIGATION = self::DATA . L::DASH . self::DETAIL . '-navigation';
    public const DATA_DETAIL_DESCRIPTION = self::DATA . L::DASH . self::DETAIL . '-description';
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
    public const FEAT_GROUPS  = self::FEAT . L::DASH . self::GROUPS;
    public const FEAT_GRID    = self::FEAT . L::DASH . self::GRID;
    public const FEAT_ORIGIN  = self::FEAT . L::DASH . self::ORIGIN;
    public const FEAT_ORIGINS = self::FEAT . L::DASH . self::ORIGINS;
    public const FEAT_GROUP   = self::FEAT . L::DASH . self::GROUP;
    public const FEAT_CARD   = self::FEAT . L::DASH . self::CARD;
    public const FEAT_GROUP_TITLE = self::FEAT . L::DASH . self::GROUP . L::DASH . self::TITLE;
    public const FEAT_PREREQUIS = 'feat-prerequisite';
    public const GLOSSAIRE_CARD = 'glossaire' . L::DASH . self::CARD;
    public const SKILL_DETAIL   = self::SKILL . L::DASH . self::DETAIL;
    public const SKILL_ABILITY = self::SKILL . '-ability';
    public const SKILL_SUBSKILLS = self::SKILL . L::DASH . self::SUBSKILLS;
    public const SKILL_GROUPS = self::SKILL . L::DASH . self::GROUPS;
    public const SKILL_ORIGINS = self::SKILL . L::DASH . self::ORIGINS;
    public const SKILL_GRID   = self::SKILL . L::DASH . self::GRID;
    public const SKILL_GROUP  = self::SKILL . L::DASH . self::GROUP;
    public const SKILL_CARD   = self::SKILL . L::DASH . self::CARD;
    public const SKILL_GROUP_TITLE = self::SKILL . L::DASH . self::GROUP . L::DASH . self::TITLE;
    public const SPECIE_GROUPS  = self::SPECIE . L::DASH . self::GROUPS;
    public const SPECIE_GRID    = self::SPECIE . L::DASH . self::GRID;
    public const SPECIE_GROUP   = self::SPECIE . L::DASH . self::GROUP;
    public const SPECIE_PROPERTIES  = self::SPECIE . '-properties';
    public const SPECIE_DESCRIPTION = self::SPECIE . '-description';
    public const SPECIE_ABILITIES  = self::SPECIE . '-abilities';
    public const SPECIE_CARD   = self::SPECIE . L::DASH . self::CARD;
    public const SPECIE_GROUP_TITLE = self::SPECIE . L::DASH . self::GROUP . L::DASH . self::TITLE;
    public const ORIGIN_GROUPS  = self::ORIGIN . L::DASH . self::GROUPS;
    public const ORIGIN_GRID    = self::ORIGIN . L::DASH . self::GRID;
    public const ORIGIN_GROUP   = self::ORIGIN . L::DASH . self::GROUP;
    public const ORIGIN_CARD   = self::ORIGIN . L::DASH . self::CARD;
    public const ORIGIN_DESCRIPTION = 'origin-description';
    public const ORIGIN_PROPERTY = 'origin-property';
    public const ORIGIN_EQUIPMENT = 'origin-equipment';
    public const ORIGIN_PROPERTIES = 'origin-properties';
    public const ORIGIN_GROUP_TITLE = self::ORIGIN . L::DASH . self::GROUP . L::DASH . self::TITLE;
    public const SPELL_GROUPS  = self::SPELL . L::DASH . self::GROUPS;
    public const SPELL_GRID    = self::SPELL . L::DASH . self::GRID;
    public const SPELL_LIST    = self::SPELL . L::DASH . self::LIST;
    public const SPELL_GROUP   = self::SPELL . L::DASH . self::GROUP;
    public const SPELL_CARD   = self::SPELL . L::DASH . self::CARD;
    public const SPELL_GROUP_TITLE = self::SPELL . L::DASH . self::GROUP . L::DASH . self::TITLE;
    public const SPELL_DETAIL_DESCRIPTION   = self::SPELL . '-detail-description';
    public const SPELL_DETAIL   = self::SPELL . L::DASH . self::DETAIL;
    public const SPELL_DETAIL_INFO   = self::SPELL . L::DASH . self::DETAIL . L::DASH . self::INFO;
    public const SPELL_DETAIL_NAVIGATION   = self::SPELL . L::DASH . self::DETAIL . L::DASH . self::NAVIGATION;
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
    public const ARMOR_GRID = self::ARMOR . L::DASH . self::GRID;
    public const ARMOR_GROUP = self::ARMOR . L::DASH . self::GROUP;
    public const ARMOR_CARD = self::ARMOR . L::DASH . self::CARD;
    public const ARMOR_LIST    = self::ARMOR . L::DASH . self::LIST;
    public const ARMOR_DETAIL   = self::ARMOR . L::DASH . self::DETAIL;
    public const ARMOR_DETAIL_INFO   = self::ARMOR . L::DASH . self::DETAIL . L::DASH . self::INFO;
    public const ARMOR_DETAIL_INFOS  = self::ARMOR . L::DASH . self::DETAIL . L::DASH . self::INFOS;
    public const ARMOR_DETAIL_NAVIGATION   = self::ARMOR . L::DASH . self::DETAIL . L::DASH . self::NAVIGATION;

    public const WEAPON = 'weapon';
    public const WEAPON_GRID = self::WEAPON . L::DASH . self::GRID;
    public const WEAPON_GROUP = self::WEAPON . L::DASH . self::GROUP;
    public const WEAPON_CARD = self::WEAPON . L::DASH . self::CARD;
    public const WEAPON_CARD_INFO   = self::WEAPON . '-card-info';
    public const WEAPON_LIST    = self::WEAPON . L::DASH . self::LIST;
    public const WEAPON_DETAIL   = self::WEAPON . L::DASH . self::DETAIL;
    public const WEAPON_DETAIL_INFO   = self::WEAPON . L::DASH . self::DETAIL . L::DASH . self::INFO;
    public const WEAPON_DETAIL_INFO_VALUE = self::WEAPON . '-detail-info-value';
    public const WEAPON_DETAIL_INFOS  = self::WEAPON . L::DASH . self::DETAIL . L::DASH . self::INFOS;
    public const WEAPON_DETAIL_NAVIGATION   = self::WEAPON . L::DASH . self::DETAIL . L::DASH . self::NAVIGATION;

    public const TOOL = 'tool';
    public const TOOL_GRID = self::TOOL . L::DASH . self::GRID;
    public const TOOL_GROUP = self::TOOL . L::DASH . self::GROUP;
    public const TOOL_CARD = self::TOOL . L::DASH . self::CARD;
    public const TOOL_CARD_INFOS = self::TOOL . L::DASH . self::CARD . '-infos';
    public const TOOL_LIST    = self::TOOL . L::DASH . self::LIST;
    public const TOOL_DETAIL   = self::TOOL . L::DASH . self::DETAIL;
    public const TOOL_DETAIL_INFO   = self::TOOL . L::DASH . self::DETAIL . L::DASH . self::INFO;
    public const TOOL_DETAIL_INFO_VALUE = self::TOOL . '-detail-info-value';
    public const TOOL_DETAIL_INFOS  = self::TOOL . L::DASH . self::DETAIL . L::DASH . self::INFOS;
    public const TOOL_DETAIL_NAVIGATION   = self::TOOL . L::DASH . self::DETAIL . L::DASH . self::NAVIGATION;

    public const GEAR = 'gear';
    public const GEAR_GRID = self::GEAR . L::DASH . self::GRID;
    public const GEAR_CARD = self::GEAR . L::DASH . self::CARD;


    public const ROW_DARK_STRIPED = 'row-dark-striped';

    public const COL_1     = 'col-1';
    public const COL_2     = 'col-2';
    public const COL_3     = 'col-3';
    public const COL_6     = 'col-6';
    public const COL_7     = 'col-7';
    public const COL_12    = 'col-12';
    public const COL_MD_1  = 'col-md-1';
    public const COL_MD_2  = 'col-md-2';
    public const COL_MD_3  = 'col-md-3';
    public const COL_MD_4  = 'col-md-4';
    public const COL_MD_5  = 'col-md-5';
    public const COL_MD_6  = 'col-md-6';
    public const COL_MD_8  = 'col-md-8';
    public const COL_MD_12 = 'col-md-12';

    public const MX_AUTO = self::MX . L::DASH . self::AUTO;
    public const MY4     = self::MY . '-4';

    public const NAV_ITEM       = self::NAV . L::DASH . self::ITEM;
    public const NAV_LINK       = self::NAV . L::DASH . self::LINK;
    public const NAV_LINK_TITLE = self::NAV . L::DASH . self::LINK . L::DASH . self::TITLE;
    public const NAV_TREEVIEW   = self::NAV . L::DASH . self::TREEVIEW;

    public const FONT_ITALIC = self::FONT . L::DASH . self::ITALIC;

    public const TABLE_DARK    = self::TABLE . L::DASH . self::DARK;
    public const TABLE_SM      = self::TABLE . L::DASH . self::SM;
    public const TABLE_STRIPED = self::TABLE . L::DASH . self::STRIPED;

    public const TEXT_CENTER = self::TEXT . L::DASH . self::CENTER;
    public const TEXT_DANGER = self::TEXT . L::DASH . self::DANGER;
    public const TEXT_DARK   = self::TEXT . L::DASH . self::DARK;
    public const TEXT_END    = self::TEXT . L::DASH . self::END;
    public const TEXT_NOWRAP = self::TEXT . L::DASH . self::NOWRAP;
    public const TEXT_WHITE  = self::TEXT . L::DASH . self::WHITE;
    public const TEXT_DECO_NONE = self::TEXT . '-decoration-none';

    public const BORDER_END   = self::BORDER . L::DASH . self::END;
    public const BORDER_START = self::BORDER . L::DASH . self::START;

    public const BG_DARK = self::TEXT . L::DASH . self::BG . L::DASH . self::DARK;

    public const BTN_OUTLINE_DARK = self::BTN . L::DASH . self::OUTLINE . L::DASH . self::DARK;
    public const BTN_SM           = self::BTN . L::DASH . self::SM;

    public const WITH_MRGNTOP = 'withMarginTop';
}
