<?php
namespace src\Service;

use src\Utils\Utils;

class MonsterCalculator
{
    public static function abilityModifier(int $score, int $bonus = 0): int
    {
        return Utils::getModAbility($score, $bonus);
    }

    public static function formatModifier(int $value): string
    {
        return ($value >= 0 ? '+' : '') . $value;
    }

    public static function calculateXp(float $cr): int
    {
        $xpMap = [
            -1     => 0,
            0      => 10,
            0.125  => 25,
            0.25   => 50,
            0.5    => 100,
            1      => 200,
            2      => 450,
            3      => 700,
            4      => 1100,
            5      => 1800,
            6      => 2300,
            8      => 3900,
            9      => 5000,
            10     => 5900,
            14     => 11500,
            16     => 15000,
        ];
        return $xpMap[$cr] ?? 0;
    }

    public static function formatCr(float $cr): string
    {
        return match($cr) {
            -1 => 'aucun',
            0.125 => '1/8',
            0.25 => '1/4',
            0.5 => '1/2',
            default => (string)$cr
        };
    }
}
