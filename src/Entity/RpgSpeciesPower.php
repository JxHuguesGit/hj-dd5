<?php
namespace src\Entity;

use src\Constant\Field;
use src\Repository\RpgPower as RepositoryRpgPower;

class RpgSpeciesPower extends Entity
{
    public const TABLE = 'rpgSpeciesPower';
    public const FIELDS = [
        Field::ID,
        Field::SPECIESID,
        Field::POWERID,
        Field::RANK,
    ];

    public const FIELD_TYPES = [
        Field::SPECIESID => 'string',
        Field::POWERID => 'intPositive',
        Field::RANK => 'intPositive',
    ];

    protected string $speciesId = '';
    protected int $powerId = 0;
    protected int $rank = 0;

    public function stringify(): string
    {
        return sprintf(
            "[%s] %s - %s : %s",
            $this->id,
            $this->speciesId,
            $this->powerId,
            $this->rank
        );
    }

    public function getPower(): ?RpgPower
    {
        return $this->getRelatedEntity('powerCache', RepositoryRpgPower::class, $this->powerId);
    }
}
