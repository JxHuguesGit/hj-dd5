<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

final class CombatParticipant extends Entity
{
    public const FIELDS = [
        F::ID,
        F::COMBATID,
        F::TOKENID,
        F::MAPTOKENID,
        F::NAME,
        F::SCOREHP,
        F::MAXHP,
        F::SCOREAC,
        F::INITIATIVE,
    ];

    public const FIELD_TYPES = [
        F::COMBATID    => FieldType::INTPOSITIVE,
        F::TOKENID     => FieldType::INTNULLABLE,
        F::MAPTOKENID  => FieldType::INTNULLABLE,
        F::NAME        => FieldType::STRING,
        F::SCOREHP     => FieldType::INTPOSITIVE,
        F::MAXHP       => FieldType::INTPOSITIVE,
        F::SCOREAC     => FieldType::INTPOSITIVE,
        F::INITIATIVE  => FieldType::FLOAT,
    ];

    public const EDITABLE_FIELDS = [
        F::NAME,
        F::SCOREHP,
        F::MAXHP,
        F::SCOREAC,
        F::INITIATIVE,
    ];
}
