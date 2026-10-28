<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

/**
 * @property string $name
 * @property float $initiative
 * @property string $characterType
 * @property int $monsterId
 * @property int $level
 * @property int $ac
 * @property int $maxHp
 * @property int $curHp
 * @property int $tmpHp
 * @property int $modDex
 * @property int $percPassive
 * @property int $initiativeTrackerId
 * @property int $active
 * @property bool $reactionAvailable
 * @property bool $readyActive
 */

final class ITCharacter extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
        F::INITIATIVE,
        F::CHARACTERTYPE,
        F::MONSTERID,
        F::LEVEL,
        F::SCOREAC,
        F::MAXHP,
        F::CURHP,
        F::TMPHP,
        F::MODDEX,
        F::PERCPASSIVE,
        F::ITID,
        F::ACTIVE,
        F::REACTIONAVAIL,
        F::READYACTIVE,
    ];

    public const FIELD_TYPES = [
        F::NAME          => FieldType::STRING,
        F::INITIATIVE    => FieldType::FLOATNULLABLE,
        F::CHARACTERTYPE => FieldType::STRING,
        F::MONSTERID     => FieldType::INTPOSITIVE,
        F::LEVEL         => FieldType::INTPOSITIVE,
        F::SCOREAC       => FieldType::INTPOSITIVE,
        F::MAXHP         => FieldType::INTPOSITIVE,
        F::CURHP         => FieldType::INTPOSITIVE,
        F::TMPHP         => FieldType::INTPOSITIVE,
        F::MODDEX        => FieldType::INT,
        F::PERCPASSIVE   => FieldType::INTPOSITIVE,
        F::ITID          => FieldType::INTPOSITIVE,
        F::ACTIVE        => FieldType::INTPOSITIVE,
        F::REACTIONAVAIL => FieldType::BOOL,
        F::READYACTIVE   => FieldType::BOOL,
    ];

    public const EDITABLE_FIELDS = [
        F::NAME,
        F::INITIATIVE,
        F::CHARACTERTYPE,
        F::MONSTERID,
        F::LEVEL,
        F::SCOREAC,
        F::MAXHP,
        F::CURHP,
        F::TMPHP,
        F::MODDEX,
        F::PERCPASSIVE,
        F::ITID,
        F::ACTIVE,
        F::REACTIONAVAIL,
        F::READYACTIVE,
    ];

    public function getCharacterStats(): string
    {
        return sprintf(
            'Niveau %d • CA %d • %d PV • DEX %s • Passive %d',
            $this->level,
            $this->ac,
            $this->maxHp,
            ($this->modDex>0 ? '+' : '') . $this->modDex,
            $this->percPassive
        );
    }
}
