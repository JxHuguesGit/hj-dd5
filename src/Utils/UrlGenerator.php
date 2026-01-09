<?php
namespace src\Utils;

use src\Constant\Routes;

final class UrlGenerator
{
    public static function origin(string $slug, bool $absolute = false): string
    {
        $url = Routes::ORIGIN_PREFIX . $slug;
        return $absolute ? DD5_URL . ltrim($url, '/') : $url;
    }

    public static function feat(string $slug, bool $absolute = false): string
    {
        $url = Routes::FEAT_PREFIX . $slug;
        return $absolute ? DD5_URL . ltrim($url, '/') : $url;
    }

    public static function skill(string $slug, bool $absolute = false): string
    {
        $url = Routes::SKILL_PREFIX . $slug;
        return $absolute ? DD5_URL . ltrim($url, '/') : $url;
    }

    public static function item(string $slug, bool $absolute = false): string
    {
        $url = Routes::ITEM_PREFIX . $slug;
        return $absolute ? DD5_URL . ltrim($url, '/') : $url;
    }
}
