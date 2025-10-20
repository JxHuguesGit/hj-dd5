<?php
namespace src\Enum;

enum LanguageEnum: string
{
    case Com = 'com';
    case Adv = 'adv';
    case Pro = 'pro';
    case Pae = 'pae';

    public function label(): string
    {
        return match($this) {
            static::Com   => 'Commun',
            static::Adv   => 'Argot des voleurs',
            static::Pro   => 'Profond',
            static::Pae   => 'Primordial (Aérien)',
            default       => 'Langue inconnue.',
        };
    }
    
    public static function fromEnglish(string $english): ?self
    {
        return match(strtolower(trim($english))) {
            'common'            => self::Com,
            "thieves' cant"     => self::Adv,
            'deep'              => self::Pro,
            'primordial (air)'  => self::Pae,
            default             => null,
        };
    }    
}