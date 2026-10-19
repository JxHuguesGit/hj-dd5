<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

final class InitiativeTracker extends Entity
{
    public const FIELDS = [
        F::ID,
        F::WPUSERID,
        F::ITCODE,
        F::MAPID,
        F::NAME,
        F::ROUND,
        F::CURRENTPARTICIPANTID,
        F::ACTIVE,
    ];

    public const RELATION_FIELDS = [
        'partyMembers',
        'ennemyMembers'
    ];

    public const FIELD_TYPES = [
        F::WPUSERID             => FieldType::INTPOSITIVE,
        F::ITCODE               => FieldType::STRING,
        F::MAPID                => FieldType::INTNULLABLE,
        F::NAME                 => FieldType::STRINGNULLABLE,
        F::ROUND                => FieldType::INTPOSITIVE,
        F::CURRENTPARTICIPANTID => FieldType::INTNULLABLE,
        F::ACTIVE               => FieldType::INTPOSITIVE,

        'partyMembers'          => FieldType::COLLECTION,
        'ennemyMembers'         => FieldType::COLLECTION,
    ];

    public const EDITABLE_FIELDS = [
        F::WPUSERID,
        F::ITCODE,
        F::MAPID,
        F::NAME,
        F::ROUND,
        F::CURRENTPARTICIPANTID,
        F::ACTIVE,
    ];
}
