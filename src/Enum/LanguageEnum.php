<?php
namespace src\Enum;

enum LanguageEnum: string
{
    case Com = 'com';
    case Aar = 'aar';
    case Aby = 'aby';
    case Adv = 'adv';
    case Dra = 'dra';
    case Elf = 'elf';
    case Pro = 'pro';
    case Pae = 'pae';
    case Yet = 'yet';
    
    case Tel = 'tel';

    public function label(): string
    {
        return match($this) {
            static::Com   => 'Commun',
            static::Aar   => 'Aarakocre',
            static::Aby   => 'Abyssal',
            static::Adv   => 'Argot des voleurs',
            static::Dra   => 'Draconique',
            static::Elf   => 'Elfe',
            static::Pae   => 'Primordial (Aérien)',
            static::Pro   => 'Profond',
            static::Yet   => 'Yéti',

            static::Tel   => 'Télépathie',
            default       => 'Langue inconnue.',
        };
    }
    
    public static function fromEnglish(string $english): ?self
    {
        return match(strtolower(trim($english))) {
            'common'             => self::Com,
            "abyssal"            => self::Aby,
            "aarakocra"          => self::Aar,
            "thieves' cant"      => self::Adv,
            'draconic'           => self::Dra,
            'elvish'             => self::Elf,
            'deep speech'        => self::Pro,
            'primordial (auran)' => self::Pae,
            'yeti'               => self::Yet,
            
            'telepathy'          => self::Tel,
            default              => null,
        };
    }
}
