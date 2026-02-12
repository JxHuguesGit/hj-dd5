<?php
namespace src\Helper;

use src\Enum\SizeEnum;

class SizeHelper
{
    /**
     * Convertit une chaîne anglaise de taille en bitmask
     */
    public static function parse(string $label): int
    {
        $label = strtolower(trim($label));

        return match (true) {
            $label === 'tiny'                    => SizeEnum::Tiny->value,
            $label === 'small'                   => SizeEnum::Small->value,
            $label === 'medium'                  => SizeEnum::Medium->value,
            $label === 'large'                   => SizeEnum::Large->value,
            $label === 'huge'                    => SizeEnum::Huge->value,
            $label === 'gargantuan'              => SizeEnum::Gargantuan->value,

            $label === 'huge or smaller'         => SizeEnum::Tiny->value | SizeEnum::Small->value | SizeEnum::Medium->value | SizeEnum::Large->value | SizeEnum::Huge->value,
            $label === 'medium or small'         => SizeEnum::Small->value | SizeEnum::Medium->value,
            $label === 'huge or gargantuan'      => SizeEnum::Huge->value | SizeEnum::Gargantuan->value,
/*
            $label === 'small or medium'         => MonsterSize::Small->value | MonsterSize::Medium->value,
            $label === 'medium or large'         => MonsterSize::Medium->value | MonsterSize::Large->value,
            $label === 'tiny or small'           => MonsterSize::Tiny->value | MonsterSize::Small->value,
            $label === 'large or larger'         => MonsterSize::Large->value | MonsterSize::Huge->value | MonsterSize::Gargantuan->value,
            $label === 'medium or smaller'       => MonsterSize::Tiny->value | MonsterSize::Small->value | MonsterSize::Medium->value,
            $label === 'medium or larger'        => MonsterSize::Medium->value | MonsterSize::Large->value | MonsterSize::Huge->value | MonsterSize::Gargantuan->value,
*/
            default                              => 0,
        };
    }

    /**
     * Retourne le libellé combiné en français à partir d’un bitmask
     */
    public static function toLabelFr(int $bitmask, string $gender='f', bool $plural=false): string
    {
        $sizes = SizeEnum::fromBitmask($bitmask);

        // Trier les tailles selon leur ordre numérique croissant
        usort($sizes, fn($a, $b) => $a->value <=> $b->value);

        switch (count($sizes)) {
            case 0 :
                $returned = '';
            break;
            case 1 :
                $returned = $sizes[0]->label($gender, $plural);
            break;
            case 2 :
                $returned = $sizes[0]->label($gender, $plural) . ' ou ' . $sizes[1]->label($gender, $plural);
            break;
            default :
                $min = array_shift($sizes);
                $max = array_pop($sizes);
                // Si on a Tiny dans la sélection, on part du principe que c'est "X ou plus petit"
                if ($min === SizeEnum::Tiny) {
                    $returned = $max->label($gender, $plural) . ' ou plus petit'.($gender=='f'?'e':'').($plural?'s':'');
                } else {
                    $returned = $min->label($gender, $plural) . ' ou plus grand'.($gender=='f'?'e':'').($plural?'s':'');
                }
            break;
        }

        return $returned;
    }

}
