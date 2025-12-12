<?php
namespace src\Entity;

use src\Constant\Field;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;
use src\Repository\RpgSkill as RepositoryRpgSkill;

class RpgOriginSkill extends Entity
{
    public const TABLE = 'rpgOriginSkill';
    public const FIELDS = [
        Field::ID,
        Field::ORIGINID,
        Field::SKILLID,
    ];
    public const FIELD_TYPES = [
        Field::ORIGINID => 'intPositive',
        Field::SKILLID => 'intPositive',
    ];

    protected int $originId = 0;
    protected int $skillId = 0;

    public function getOrigin(): ?RpgOrigin
    {
        return $this->getRelatedEntity('originCache', RepositoryRpgOrigin::class, $this->originId);
    }

    public function getSkill(): ?RpgSkill
    {
        return $this->getRelatedEntity('skillCache', RepositoryRpgSkill::class, $this->skillId);
    }
}
