<?php
namespace src\Constant;

class Bootstrap
{
    public const CENTER    = 'center';
    public const DARK      = 'dark';
    public const DANGER    = 'danger';
    public const LINK      = 'link';
    public const END       = 'end';
    public const FONT      = 'font';
    public const ITEM      = 'item';
    public const ITALIC    = 'italic';
    public const MB3       = 'mb-3';
    public const MT5       = 'mt-5';
    public const NAV       = 'nav';
    public const SM        = 'sm';
    public const STRIPED   = 'striped';
    public const TABLE     = 'table';
    public const TEXT      = 'text';
    public const AUTO      = 'auto';
    public const DNONE     = 'd-none';
    public const BTN       = 'btn';
    public const BG        = 'bg';
    public const MX        = 'mx';
    public const MY        = 'my';
    public const BADGE     = 'badge';
    public const OUTLINE   = 'outline';
    public const WHITE     = 'white';
    public const TITLE     = 'title';
    public const NOWRAP    = 'nowrap';
    public const TREEVIEW  = 'treeview';
    public const MENU_OPEN = 'menu-open';

    public const ROW_DARK_STRIPED = 'row-dark-striped';

    public const COL_1     = 'col-1';
    public const COL_2     = 'col-2';
    public const COL_12    = 'col-12';
    public const COL_MD_2  = 'col-md-2';
    public const COL_MD_3  = 'col-md-3';
    public const COL_MD_4  = 'col-md-4';
    public const COL_MD_5  = 'col-md-5';
    public const COL_MD_8  = 'col-md-8';
    public const COL_MD_12 = 'col-md-12';

    public const MX_AUTO = self::MX . '-' . self::AUTO;
    public const MY4     = self::MY . '-4';

    public const NAV_LINK       = self::NAV . '-' . self::LINK;
    public const NAV_ITEM       = self::NAV . '-' . self::ITEM;
    public const NAV_TREEVIEW   = self::NAV . '-' . self::TREEVIEW;
    public const NAV_LINK_TITLE = self::NAV . '-' . self::LINK . '-' . self::TITLE;

    public const FONT_ITALIC = self::FONT . '-' . self::ITALIC;

    public const TABLE_SM      = self::TABLE . '-' . self::SM;
    public const TABLE_STRIPED = self::TABLE . '-' . self::STRIPED;
    public const TABLE_DARK    = self::TABLE . '-' . self::DARK;

    public const TEXT_CENTER = self::TEXT . '-' . self::CENTER;
    public const TEXT_DARK   = self::TEXT . '-' . self::DARK;
    public const TEXT_WHITE  = self::TEXT . '-' . self::WHITE;
    public const TEXT_DANGER = self::TEXT . '-' . self::DANGER;
    public const TEXT_END    = self::TEXT . '-' . self::END;
    public const TEXT_NOWRAP = self::TEXT . '-' . self::NOWRAP;

    public const BG_DARK = self::TEXT . '-' . self::BG . '-' . self::DARK;

    public const BTN_SM           = self::BTN . '-' . self::SM;
    public const BTN_OUTLINE_DARK = self::BTN . '-' . self::OUTLINE . '-' . self::DARK;

    public const WITH_MRGNTOP = 'withMarginTop';
}
