<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

final class WeaponPropertyValue extends Entity
{
    public const FIELDS = [
        Field::WEAPONID,
        Field::WPNPROPID,
        Field::MINRANGE,
        Field::MAXRANGE,
        Field::TYPEAMMID,
        Field::DMGDIEID,

        Field::PROPERTYNAME,
        Field::PROPERTYSLUG,
        Field::POSTID,

        Field::AMMONAME,

        Field::DICECOUNT,
        Field::DICEFACES,
    ];

    public const FIELD_TYPES = [
        Field::WEAPONID  => FieldType::INTPOSITIVE,
        Field::WPNPROPID => FieldType::INTPOSITIVE,
        Field::MINRANGE  => FieldType::INTNULLABLE,
        Field::MAXRANGE  => FieldType::INTNULLABLE,
        Field::TYPEAMMID => FieldType::INTNULLABLE,
        Field::DMGDIEID  => FieldType::INTNULLABLE,

        Field::PROPERTYNAME => FieldType::STRINGNULLABLE,
        Field::PROPERTYSLUG => FieldType::STRINGNULLABLE,
        Field::POSTID       => FieldType::INTPOSITIVE,

        Field::AMMONAME     => FieldType::STRINGNULLABLE,

        Field::DICECOUNT  => FieldType::INTNULLABLE,
        Field::DICEFACES  => FieldType::INTNULLABLE,
    ];
}
