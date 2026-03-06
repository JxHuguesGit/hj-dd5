<?php
namespace src\Utils;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Icon;

class Html
{
    public const SELF_CLOSING_TAGS = ['img', 'input', 'br', 'hr', 'meta', B::LINK];

    public static function getBalise(string $balise, string $label = '', array $attributes = []): string
    {
        if (in_array($balise, self::SELF_CLOSING_TAGS)) {
            return '<' . $balise . static::getExtraAttributesString($attributes) . '/>';
        } else {
            return '<' . $balise . static::getExtraAttributesString($attributes) . '>' . $label . '</' . $balise . '>';
        }
    }

    public static function getExtraAttributesString(array $attributes): string
    {
        $extraAttributes = '';
        foreach ($attributes as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subkey => $subvalue) {
                    $extraAttributes .= sprintf(
                        ' %s-%s="%s"',
                        htmlspecialchars((string) $key, ENT_QUOTES, 'UTF-8'),
                        htmlspecialchars((string) $subkey, ENT_QUOTES, 'UTF-8'),
                        htmlspecialchars((string) $subvalue, ENT_QUOTES, 'UTF-8')
                    );
                }
            } else {
                $extraAttributes .= sprintf(
                    ' %s="%s"',
                    htmlspecialchars((string) $key, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8')
                );
            }
        }
        return $extraAttributes;
    }

    public static function getButton(string $label, array $extraAttributes = []): string
    {
        // Les attributs par défaut d'un bouton.
        $defaultAttributes = [
            C::TYPE  => 'button',
            C::CSSCLASS => self::mergeClasses($extraAttributes, 'btn btn-default btn-sm'),
        ];
        $attributes = array_merge($defaultAttributes, $extraAttributes);
        return static::getBalise('button', $label, $attributes);
    }

    public static function getDiv(string $content, array $extraAttributes = []): string
    {
        return static::getBalise('div', $content, $extraAttributes);
    }

    public static function getUl(string $content, array $extraAttributes = []): string
    {
        return static::getBalise('ul', $content, $extraAttributes);
    }

    public static function getOption(string $label, array $attributes, bool $isSelected = false): string
    {
        if ($isSelected) {
            $attributes[C::SELECTED] = C::SELECTED;
        }
        return static::getBalise(C::PAGE_OPTION, $label, $attributes);
    }

    public static function getLi(string $content, array $extraAttributes = []): string
    {
        return static::getBalise('li', $content, $extraAttributes);
    }

    public static function getLink(string $label, string $href, string $classe = '', array $extraAttributes = []): string
    {
        $attributes = array_merge(
            [C::HREF => $href, C::CSSCLASS => $classe],
            $extraAttributes
        );
        return static::getBalise('a', $label, $attributes);
    }

    public static function getSpan(string $content, array $extraAttributes = []): string
    {
        return static::getBalise('span', $content, $extraAttributes);
    }

    public static function getIcon(string $icon, string $prefix = Icon::SOLID, array $extraAttributes = []): string
    {
        $strClass = self::mergeClasses(
            $extraAttributes,
            'fa-' . $prefix . ' fa-' . $icon
        );
        $attributes = array_merge([C::CSSCLASS => $strClass], $extraAttributes);
        return static::getBalise('i', '', $attributes);
    }

    public static function shortcodes(string $content = ''): string
    {
        $pattern = "/\[(feat)]([^\[]*)\[\/feat]/";
        if (preg_match_all($pattern, $content, $matches)) {
            $nb = count($matches[0]);
            for ($i = 0; $i < $nb; $i++) {
                $content = str_replace($matches[0][$i], sprintf(
                    '<span class="mr-2 modal-link" data-modal="%s" data-key="%s">%s </span>', esc_attr($matches[1][$i]), sanitize_title($matches[2][$i]), esc_html($matches[2][$i])), $content);
            }
        }
        return $content;
    }

    private static function mergeClasses(array &$attributes, string $defaultClass): string
    {
        if (isset($attributes[C::CSSCLASS])) {
            $defaultClass .= ' ' . $attributes[C::CSSCLASS];
            unset($attributes[C::CSSCLASS]);
        }
        if (isset($attributes['replaceclass'])) {
            $defaultClass = $attributes['replaceclass'];
            unset($attributes['replaceclass']);
        }
        return $defaultClass;
    }
}
