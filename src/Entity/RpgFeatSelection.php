<?php
namespace src\Entity;

use src\Constant\Field;

class RpgFeatSelection extends Entity
{
    public const TABLE = 'rpgFeatSelection';
    public const FIELDS = [
        Field::ID,
        Field::ENTITYTYPE,
        Field::ENTITYID,
        Field::FEATID,
        Field::OPTIONID,
    ];

    public const FIELD_TYPES = [
        Field::ENTITYTYPE => 'enum',
        Field::ENTITYID => 'intPositive',
        Field::FEATID => 'intPositive',
        Field::OPTIONID => 'intPositive',
    ];

    public const ENUMS = [
        Field::ENTITYTYPE => ['origin', 'character'],
    ];

    protected string $entityType = '';
    protected int $entityId = 0;
    protected int $featId = 0;
    protected int $optionId = 0;

}
