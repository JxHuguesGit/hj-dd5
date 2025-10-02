<?php
namespace src\Utils;

use src\Constant\Language;

class Utils
{
    public static function formatStringAbility(int $value): string
    {
        $strReturned = $value < 0 ? 'moins ' : 'plus ';
        return $strReturned . abs($value);
    }
    
    public static function formatStringModAbility(int $value): string
    {
        return ($value >= 0 ? '+' : '').$value;
    }
    
    public static function getModAbility(int $value): int
    {
        return floor($value/2)-5;
    }
    
    public static function getStrWeight(float $value): string
    {
        switch ($value) {
            case 0 :
                $strPoids = '-';
            break;
            case 0.125 :
                $strPoids = '125 g';
            break;
            case 0.25 :
                $strPoids = '250 g';
            break;
            default :
                $strPoids = $value.Language::LG_KG;
            break;
        }
        return $strPoids;
    }
    
    public static function getStrPrice(float $value): string
    {
        if ($value<0.1) {
            $strPrix = ($value*100).' pc';
        } elseif ($value<1) {
            $strPrix = ($value*10).' pa';
        } else {
            $strPrix = $value.Language::LG_GP;
        }
        return $strPrix;
    }
    
}
