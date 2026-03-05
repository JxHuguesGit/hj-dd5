<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

final class WeaponPropertyValue extends Entity
{
    public const FIELDS = [
        F::WEAPONID,
        F::WPNPROPID,
        F::MINRANGE,
        F::MAXRANGE,
        F::TYPEAMMID,
        F::DMGDIEID,

        F::PROPERTYNAME,
        F::PROPERTYSLUG,
        F::POSTID,

        F::AMMONAME,

        F::DICECOUNT,
        F::DICEFACES,
    ];

    public const FIELD_TYPES = [
        F::WEAPONID  => FieldType::INTPOSITIVE,
        F::WPNPROPID => FieldType::INTPOSITIVE,
        F::MINRANGE  => FieldType::INTNULLABLE,
        F::MAXRANGE  => FieldType::INTNULLABLE,
        F::TYPEAMMID => FieldType::INTNULLABLE,
        F::DMGDIEID  => FieldType::INTNULLABLE,

        F::PROPERTYNAME => FieldType::STRINGNULLABLE,
        F::PROPERTYSLUG => FieldType::STRINGNULLABLE,
        F::POSTID       => FieldType::INTPOSITIVE,

        F::AMMONAME     => FieldType::STRINGNULLABLE,

        F::DICECOUNT  => FieldType::INTNULLABLE,
        F::DICEFACES  => FieldType::INTNULLABLE,
    ];
}
