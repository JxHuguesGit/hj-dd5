<?php
namespace src\Enum;

enum SkillEnum: string
{
    case Acr = 'acr';
    case Arc = 'arc';
    case Ath = 'ath';
    case Ste = 'ste';
    case Ani = 'ani';
    case Soh = 'soh';
    case His = 'his';
    case Int = 'int';
    case Ins = 'ins';
    case Inv = 'inv';
    case Med = 'med';
    case Nat = 'nat';
    case Pec = 'pec';
    case Pes = 'pes';
    case Rel = 'rel';
    case Pef = 'pef';
    case Sur = 'sur';
    case Dec = 'dec';
    case End = 'end';

    public function label(): string
    {
        return match($this) {
            static::Acr   => 'Acrobaties',
            static::Ani   => 'Dressage',
            static::Arc   => 'Arcanes',
            static::Ath   => 'Athlétisme',
            static::Dec   => 'Tromperie',
            static::End   => 'Endurance',
            static::His   => 'Histoire',
            static::Ins   => 'Intuition',
            static::Int   => 'Intimidation',
            static::Inv   => 'Investigation',
            static::Med   => 'Médecine',
            static::Nat   => 'Nature',
            static::Pec   => 'Perception',
            static::Pef   => 'Représentation',
            static::Pes   => 'Persuasion',
            static::Rel   => 'Religion',
            static::Soh   => 'Escamotage',
            static::Ste   => 'Discrétion',
            static::Sur   => 'Survie',
            default       => 'Compétence inconnue.',
        };
    }

    public function ability(): AbilityEnum
    {
        return match($this) {
            self::Acr => AbilityEnum::Dex,
            self::Ani => AbilityEnum::Wis,
            self::Arc => AbilityEnum::Int,
            self::Ath => AbilityEnum::Str,
            self::Dec => AbilityEnum::Cha,
            self::End => AbilityEnum::Con,
            self::His => AbilityEnum::Int,
            self::Ins => AbilityEnum::Wis,
            self::Int => AbilityEnum::Cha,
            self::Inv => AbilityEnum::Int,
            self::Med => AbilityEnum::Wis,
            self::Nat => AbilityEnum::Int,
            self::Pec => AbilityEnum::Wis,
            self::Pef => AbilityEnum::Cha,
            self::Pes => AbilityEnum::Cha,
            self::Rel => AbilityEnum::Int,
            self::Soh => AbilityEnum::Dex,
            self::Ste => AbilityEnum::Dex,
            self::Sur => AbilityEnum::Wis,
        };
    }
    
    public static function fromEnglish(string $english): ?self
    {
        return match(strtolower(trim($english))) {
            'acrobatics'     => self::Acr,
            'animal handling'=> self::Ani,
            'arcana'         => self::Arc,
            'athletics'      => self::Ath,
            'deception'      => self::Dec,
            'endurance'      => self::End,
            'history'        => self::His,
            'insight'        => self::Ins,
            'intimidation'   => self::Int,
            'investigation'  => self::Inv,
            'medicine'       => self::Med,
            'nature'         => self::Nat,
            'perception'     => self::Pec,
            'performance'    => self::Pef,
            'persuasion'     => self::Pes,
            'religion'       => self::Rel,
            'sleight of hand'=> self::Soh,
            'stealth'        => self::Ste,
            'survival'       => self::Sur,
            default          => null,
        };
    }
}
