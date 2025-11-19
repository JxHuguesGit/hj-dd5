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

    private const ENGLISH_MAP = [
        'common'             => self::Com,
        'abyssal'            => self::Aby,
        'aarakocra'          => self::Aar,
        "thieves' cant"      => self::Adv,
        'draconic'           => self::Dra,
        'elvish'             => self::Elf,
        'deep speech'        => self::Pro,
        'primordial (auran)' => self::Pae,
        'yeti'               => self::Yet,
        'telepathy'          => self::Tel,
    ];

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
        return self::ENGLISH_MAP[strtolower(trim($english))] ?? null;
    }

    public static function labelFromDb(string $value): ?string
    {
        return self::tryFrom($value)?->label();
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return array_map(fn($case) => $case->label(), self::cases());
    }
}
