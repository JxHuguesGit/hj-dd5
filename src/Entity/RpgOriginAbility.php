<?php
namespace src\Entity;

use src\Constant\Field;
use src\Repository\RpgAbility as RepositoryRpgAbility;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;

class RpgOriginAbility extends Entity
{
    public const TABLE = 'rpgOriginAbility';
    public const FIELDS = [
        Field::ID,
        Field::ORIGINID,
        Field::ABILITYID,
    ];

    public const FIELD_TYPES = [
        Field::ORIGINID => 'intPositive',
        Field::ABILITYID => 'intPositive',
    ];

    protected int $originId = 0;
    protected int $abilityId = 0;

    public function getOrigin(): ?RpgOrigin
    {
        return $this->getRelatedEntity('originCache', RepositoryRpgOrigin::class, $this->originId);
    }

    public function getAbility(): ?RpgAbility
    {
        return $this->getRelatedEntity('abilityCache', RepositoryRpgAbility::class, $this->abilityId);
    }
}

