<?php
namespace src\Utils;

use src\Constant\Constant;

class Html
{
    /** @var array<string> */
    private const SELF_CLOSING_TAGS = [
        'img', 'input', 'br', 'hr', 'meta', 'link', 'source'
    ];

    /* ------------------------------------------------------------
        Public API
       ------------------------------------------------------------ */
    public static function getBalise(string $tag, string $content = '', array $attributes = []): string
    {
        $attr = self::attributesToString($attributes);

        // Balise auto-fermante
        if (in_array($tag, self::SELF_CLOSING_TAGS, true)) {
            return "<{$tag}{$attr}/>";
        }

        return "<{$tag}{$attr}>"
             . self::escape($content)
             . "</{$tag}>";
    }

    public static function getButton(string $label, array $extraAttributes = []): string
    {
        // Attributs par défaut
        $defaultAttributes = [
            Constant::CST_TYPE => 'button',
            Constant::CST_CLASS => 'btn btn-default btn-sm'
        ];

        // Gestion du remplacement complet de la classe
        if (isset($extraAttributes['replaceclass'])) {
            $defaultAttributes[Constant::CST_CLASS] = $extraAttributes['replaceclass'];
            unset($extraAttributes['replaceclass']);
        }
        // Gestion de la concaténation de classes
        elseif (isset($extraAttributes[Constant::CST_CLASS])) {
            $defaultAttributes[Constant::CST_CLASS] .= ' ' . $extraAttributes[Constant::CST_CLASS];
            unset($extraAttributes[Constant::CST_CLASS]);
        }

        $attributes = array_merge($defaultAttributes, $extraAttributes);

        return self::getBalise('button', $label, $attributes);
    }

    public static function getDiv(string $content, array $extraAttributes = []): string
    {
        return self::getBalise('div', $content, $extraAttributes);
    }

    public static function getOption(string $label, array $attributes, bool $isSelected = false): string
    {
        if ($isSelected) {
            $attributes['selected'] = true; // attribut booléen HTML5
        }
        return self::getBalise('option', $label, $attributes);
    }

    public static function getLi(string $content, array $extraAttributes = []): string
    {
        return self::getBalise('li', $content, $extraAttributes);
    }

    public static function getLink(string $label, string $href, string $class = '', array $extraAttributes = []): string
    {
        $attributes = array_merge(
            [
                Constant::CST_HREF  => $href,
                Constant::CST_CLASS => $class
            ],
            $extraAttributes
        );

        return self::getBalise('a', $label, $attributes);
    }

    public static function getSpan(string $content, array $extraAttributes = []): string
    {
        return self::getBalise('span', $content, $extraAttributes);
    }

    public static function getIcon(string $icon, string $prefix = 'solid', array $extraAttributes = []): string
    {
        $class = "fa-{$prefix} fa-{$icon}";
        $attributes = array_merge(
            [ Constant::CST_CLASS => $class ],
            $extraAttributes
        );

        return self::getBalise('i', '', $attributes);
    }


    /* ------------------------------------------------------------
        Internal helpers
       ------------------------------------------------------------ */

    private static function attributesToString(array $attributes): string
    {
        $html = '';

        foreach ($attributes as $key => $value) {

            // Attributs booléens (HTML5)
            if ($value === true) {
                $html .= ' ' . self::escape($key);
                continue;
            }

            // Attributs ignorés
            if ($value === false || $value === null) {
                continue;
            }

            // Attributs complexes (tableaux → data-x-y)
            if (is_array($value)) {
                foreach ($value as $subkey => $subvalue) {
                    $html .= ' '
                        . self::escape("{$key}-{$subkey}")
                        . '="'
                        . self::escape((string) $subvalue)
                        . '"';
                }
                continue;
            }

            // Attribut standard
            $html .= ' ' . self::escape($key)
                  . '="' . self::escape((string) $value) . '"';
        }

        return $html;
    }


    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}