<?php
namespace src\Enum;

enum ConditionEnum: string
{
    case Pro = 'pro';
    case Dea = 'dea';
    case Bli = 'bli';
    case Cha = 'cha';
    case Fri = 'fri';
    case Poi = 'poi';
    case Res = 'res';
    case Stu = 'stu';
    case Unc = 'unc';
    case Neu = 'neu';
    case Par = 'par';
    case Pet = 'pet';
    case Gra = 'gra';
    case Exh = 'exh';

    public function label(): string
    {
        return match($this) {
            static::Pro   => 'À terre',
            static::Dea   => 'Assourdi',
            static::Bli   => 'Aveuglé',
            static::Cha   => 'Charmé',
            static::Fri   => 'Effrayé',
            static::Poi   => 'Empoisonné',
            static::Res   => 'Entravé',
            static::Stu   => 'Étourdi',
            static::Unc   => 'Inconscient',
            static::Neu   => 'Neutralisé',
            static::Par   => 'Paralysé',
            static::Pet   => 'Pétrifié',
            static::Gra   => 'Agrippé',
            static::Exh   => 'Épuisement',
            default       => 'Condition inconnue.',
        };
    }
    
    public static function fromEnglish(string $english): ?self
    {
        return match(strtolower(trim($english))) {
            'prone'          => self::Pro,
            'deafened'       => self::Dea,
            'blinded'        => self::Bli,
            'charmed'        => self::Cha,
            'frightened'     => self::Fri,
            'poisoned'       => self::Poi,
            'restrained'     => self::Res,
            'stunned'        => self::Stu,
            'unconscious'    => self::Unc,
            'neutralized'    => self::Neu,
            'paralyzed'      => self::Par,
            'petrified'      => self::Pet,
            'grappled'       => self::Gra,
            'exhaustion'     => self::Exh,
            default          => null,
        };
    }
}
