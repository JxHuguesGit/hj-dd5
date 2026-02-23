<?php
namespace src\Utils;

use src\Constant\Routes;

final class UrlGenerator
{
    private static function build(string $prefix, string $slug, bool $absolute): string
    {
        $url = $prefix . $slug;
        return $absolute ? DD5_URL . ltrim($url, '/') : $url;
    }

    public static function admin(string $onglet, string $subOnglet, string $slug='', string $action='', array $params=[]): string
    {
        $url = '/wp-admin/admin.php?page=hj-dd5/admin_manage.php'
            . '&onglet='.$onglet
            . '&id='.$subOnglet;
        if ($slug!='') {
            $url .= '&slug='.$slug;
        }
        if ($action!='') {
            $url .= '&action='.$action;
        }
        foreach ($params as $key=>$value) {
            $url .= '&'.$key.'='.$value;
        }
        return $url;
    }

    public static function origin(string $slug, bool $absolute = false): string
    {
        return self::build(Routes::ORIGIN_PREFIX, $slug, $absolute);
    }

    public static function feat(string $slug, bool $absolute = false): string
    {
        return self::build(Routes::FEAT_PREFIX, $slug, $absolute);
    }

    public static function feats(string $slug='', bool $absolute = false): string
    {
        return self::build(Routes::FEATS_PREFIX, $slug, $absolute);
    }

    public static function skill(string $slug, bool $absolute = false): string
    {
        return self::build(Routes::SKILL_PREFIX, $slug, $absolute);
    }

    public static function item(string $slug, bool $absolute = false): string
    {
        return self::build(Routes::ITEM_PREFIX, $slug, $absolute);
    }

    public static function specie(string $slug, bool $absolute = false): string
    {
        return self::build(Routes::SPECIE_PREFIX, $slug, $absolute);
    }

    public static function spell(string $slug, bool $absolute = false): string
    {
        return self::build(Routes::SPELL_PREFIX, $slug, $absolute);
    }

    public static function spells(string $slug='', bool $absolute = false): string
    {
        return self::build(Routes::SPELLS_PREFIX, $slug, $absolute);
    }

}
