<?php
namespace src\Constant;

class Bootstrap
{
    public const CSS_CENTER        = 'center';
    public const CSS_DARK          = 'dark';
    public const CSS_END           = 'end';
    public const CSS_FONT          = 'font';
    public const CSS_ITALIC        = 'italic';
    public const CSS_MT5           = 'mt-5';
    public const CSS_SM            = 'sm';
    public const CSS_STRIPED       = 'striped';
    public const CSS_TABLE         = 'table';
    public const CSS_TEXT          = 'text';
    public const CSS_DNONE         = 'd-none';
    public const CSS_BTN           = 'btn';
    public const CSS_OUTLINE       = 'outline';
    public const CSS_WHITE         = 'white';
    
    public const CSS_ROW_PRIMARY_STRIPED_EVEN = 'row-primary-striped-even';
    public const CSS_ROW_PRIMARY_STRIPED_ODD  = 'row-primary-striped-odd';
    public const CSS_ROW_DARK_STRIPED         = 'row-dark-striped';
    
    public const CSS_COL_MD_2      = 'col-md-2';
    public const CSS_COL_MD_3      = 'col-md-3';
    public const CSS_COL_MD_9      = 'col-md-9';
    
    public const CSS_FONT_ITALIC   = self::CSS_FONT.'-'.self::CSS_ITALIC;
    public const CSS_TABLE_SM      = self::CSS_TABLE.'-'.self::CSS_SM;
    public const CSS_TABLE_STRIPED = self::CSS_TABLE.'-'.self::CSS_STRIPED;
    public const CSS_TABLE_DARK    = self::CSS_TABLE.'-'.self::CSS_DARK;
    public const CSS_TEXT_CENTER   = self::CSS_TEXT.'-'.self::CSS_CENTER;
    public const CSS_TEXT_DARK     = self::CSS_TEXT.'-'.self::CSS_DARK;
    public const CSS_TEXT_WHITE    = self::CSS_TEXT.'-'.self::CSS_WHITE;
    public const CSS_TEXT_END      = self::CSS_TEXT.'-'.self::CSS_END;

    public const CSS_BTN_SM     = self::CSS_BTN.'-'.self::CSS_SM;
    public const CSS_BTN_OUTLINE_DARK = self::CSS_BTN.'-'.self::CSS_OUTLINE.'-'.self::CSS_DARK;

    public const CSS_WITH_MRGNTOP = 'withMarginTop';
}
