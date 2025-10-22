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




    public static function getButton(string $label, array $extraAttributes=[]): string
    {
        // Les attributs par défaut d'un bouton.
        $defaultAttributes = [
            Constant::CST_TYPE => 'button',
            Constant::CST_CLASS => 'btn btn-default btn-sm'
        ];
        if (isset($extraAttributes[Constant::CST_CLASS])) {
            $defaultAttributes[Constant::CST_CLASS] .= ' '.$extraAttributes[Constant::CST_CLASS];
            unset($extraAttributes[Constant::CST_CLASS]);
        }
        $attributes = array_merge($defaultAttributes, $extraAttributes);
        return static::getBalise('button', $label, $attributes);
    }
    
    public static function getDiv(string $content, array $extraAttributes=[]): string
    {
        return static::getBalise('div', $content, $extraAttributes);
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
    
    public static function shortcodes($content = '')
    {
        $pattern = "/\[(feat)]([^\[]*)\[\/feat]/";
        if (preg_match_all($pattern, $content, $matches)) {
            $nb = count($matches[0]);
            for ($i=0; $i<$nb; $i++) {
                $content = str_replace($matches[0][$i], sprintf(
        '<span class="mr-2 modal-link" data-modal="%s" data-key="%s">%s </span>', esc_attr($matches[1][$i]), sanitize_title($matches[2][$i]), esc_html($matches[2][$i])), $content);
            }
            //var_dump($matches);
            //$content .= 'Preg Ok : '.$matches[1];
        } else {
            //$content .= 'Preg Ko';
        }
        return $content;
        /*
        // Nettoyage du contenu entre les balises
        $label = trim($content);
        $slug = sanitize_title($label); // Pour générer data-key

    return sprintf(
        '<span>%s <i class="fa-solid fa-info-circle float-end" data-modal="feat" data-key="%s"></i></span>',
        esc_html($label),
        esc_attr($slug)
    );
    */
    }
}
