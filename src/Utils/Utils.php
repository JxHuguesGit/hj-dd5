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
    
    public static function getModAbility(int $value, $bonus=0): int
    {
        return floor($value/2)-5+$bonus;
    }
    

	public static function getUnformatCr(mixed $cr): mixed
    {
        $crMap = [
            'aucun' => -1,
            '1/8'   => 0.125,
            '1/4'   => 0.25,
            '1/2'   => 0.5,
        ];
        return $crMap[$cr] ?? $cr;
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

    public static function formatBBCode(string $str): string
    {
        $pattern = '/\[etat\](.*?)\[\/etat\]/i';
        $str = preg_replace($pattern, '<span class="modal-tooltip" data-modal="etat" data-id="$1">$1 <span class="fa fa-search"></span></span>', $str);

        $pattern = '/\[feat\](.*?)\[\/feat\]/i';
        $str = preg_replace($pattern, '<span class="modal-tooltip" data-modal="feat" data-postid="">$1 <span class="fa fa-search"></span></span>', $str);

        $pattern = '/\[monster\](.*?)\[\/monster\]/i';
        $str = preg_replace($pattern, '<span class="modal-tooltip" data-modal="monster" data-postid="">$1 <span class="fa fa-search"></span></span>', $str);

        $search = ['[b]', '[/b]', '[i]', '[/i]', '[u]', '[/u]', '[br]', "\n"];
        $replace = ['<strong>', '</strong>', '<em>', '</em>', '<u>', '</u>', '<br/>', '<br/>'];
        return str_ireplace($search, $replace, $str);
    }
    
}
