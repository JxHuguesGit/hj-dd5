<?php
namespace src\Utils;

use src\Constant\Constant;

class Html
{
    public static function getBalise(string $balise, string $label='', array $attributes=[]): string
    {
        if (in_array($balise, ['img', 'input'])) {
            return '<'.$balise.static::getExtraAttributesString($attributes).'/>';
        } else {
            return '<'.$balise.static::getExtraAttributesString($attributes).'>'.$label.'</'.$balise.'>';
        }
    }

    public static function getExtraAttributesString(array $attributes): string
    {
        $extraAttributes = '';
        // Si la liste des attributs n'est pas vide
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                // Si l'attribut est un tableau
                if (is_array($value)) {
                    foreach ($value as $subkey => $subvalue) {
                        // On construit sur le modèle key-subkey="value"
                        $extraAttributes .= ' '.$key.'-'.$subkey.'="'.$subvalue.'"';
                    }
                } else {
                    // On construit sur le modèle key="value"
                    $extraAttributes .= ' '.$key.'="'.$value.'"';
                }
            }
        }
        return $extraAttributes;
    }

    public static function getOption(string $label, array $attributes, bool $isSelected=false): string
    {
        if ($isSelected) {
            $attributes['selected'] = 'selected';
        }
        return self::getBalise('option', $label, $attributes);
    }
    
    public static function getLi(string $content, array $extraAttributes=[]): string
    {
        return static::getBalise('li', $content, $extraAttributes);
    }

    public static function getLink(string $label, string $href, string $classe='', array $extraAttributes=[]): string
    {
        $attributes = array_merge(
            [Constant::CST_HREF => $href, Constant::CST_CLASS => $classe],
            $extraAttributes
        );
        return static::getBalise('a', $label, $attributes);
    }
    
    public static function getSpan(string $content, array $extraAttributes=[]): string
    {
        return static::getBalise('span', $content, $extraAttributes);
    }
    
    public static function getIcon(string $icon, string $prefix='solid', array $extraAttributes=[]): string
    {
        $strClass = 'fa-'.$prefix.' fa-'.$icon;
        $attributes = array_merge(
            [Constant::CST_CLASS=>$strClass],
            $extraAttributes
        );
        return self::getBalise('i', '', $attributes);
    }
}
