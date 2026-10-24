<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

/**
 * @property string $name
 * @property int $initiative
 * @property string $characterType
 * @property int $level
 * @property int $ac
 * @property int $maxHp
 * @property int $curHp
 * @property int $modDex
 * @property int $percPassive
 * @property int $initiativeTrackerId
 * @property int $active
 */

final class ITCharacter extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
        F::INITIATIVE,
        F::CHARACTERTYPE,
        F::LEVEL,
        F::SCOREAC,
        F::MAXHP,
        F::CURHP,
        F::MODDEX,
        F::PERCPASSIVE,
        F::ITID,
        F::ACTIVE,
    ];

    public const FIELD_TYPES = [
        F::NAME          => FieldType::STRING,
        F::INITIATIVE    => FieldType::FLOATNULLABLE,
        F::CHARACTERTYPE => FieldType::STRING,
        F::LEVEL         => FieldType::INTPOSITIVE,
        F::SCOREAC       => FieldType::INTPOSITIVE,
        F::MAXHP         => FieldType::INTPOSITIVE,
        F::CURHP         => FieldType::INTPOSITIVE,
        F::MODDEX        => FieldType::INT,
        F::PERCPASSIVE   => FieldType::INTPOSITIVE,
        F::ITID          => FieldType::INTPOSITIVE,
        F::ACTIVE        => FieldType::INTPOSITIVE,
    ];

    public const EDITABLE_FIELDS = [
        F::NAME,
        F::INITIATIVE,
        F::CHARACTERTYPE,
        F::LEVEL,
        F::SCOREAC,
        F::MAXHP,
        F::CURHP,
        F::MODDEX,
        F::PERCPASSIVE,
        F::ACTIVE,
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
