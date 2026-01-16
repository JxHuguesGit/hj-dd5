<?php
namespace src\Helper;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class NavigationHelper
{
    public static function getPrevNext(array $data, string $entity): array
    {
        $prevHtml = $data[Constant::CST_PREV]
            ? Html::getLink(
                '&lt; ' . $data[Constant::CST_PREV][Constant::CST_NAME],
                self::generateUrl($entity, $data[Constant::CST_PREV][Constant::CST_SLUG]),
                implode(' ', [Bootstrap::CSS_BTN, Bootstrap::CSS_BTN_SM, Bootstrap::CSS_BTN_OUTLINE_DARK])
            )
            : Constant::CST_EMPTY_SPAN;
            
        $nextHtml = $data[Constant::CST_NEXT]
            ? Html::getLink(
                $data[Constant::CST_NEXT][Constant::CST_NAME].' &gt;',
                self::generateUrl($entity, $data[Constant::CST_NEXT][Constant::CST_SLUG]),
                implode(' ', [Bootstrap::CSS_BTN, Bootstrap::CSS_BTN_SM, Bootstrap::CSS_BTN_OUTLINE_DARK])
            )
            : Constant::CST_EMPTY_SPAN;
        
        return [$prevHtml, $nextHtml];
    }
    
    private static function generateUrl(string $entity, string $slug): string
    {
        return match ($entity) {
            Constant::CST_FEAT => UrlGenerator::feat($slug),
            Constant::ORIGIN   => UrlGenerator::origin($slug),
            Constant::SPECIE   => UrlGenerator::specie($slug),
            default => '#',
        };
    }
}
