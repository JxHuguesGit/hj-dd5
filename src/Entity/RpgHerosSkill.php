<?php
namespace src\Entity;

use src\Constant\Field;
use src\Repository\RpgHeros as RepositoryRpgHeros;
use src\Repository\RpgSkill as RepositoryRpgSkill;

class RpgHerosSkill extends Entity
{
    public const TABLE = 'rpgHerosSkill';
    public const FIELDS = [
        Field::ID,
        Field::HEROSID,
        Field::SKILLID,
        Field::EXPERTISE,
    ];

    public const FIELD_TYPES = [
        Field::HEROSID => 'intPositive',
        Field::SKILLID => 'intPositive',
        Field::EXPERTISE => 'bool',
    ];

    protected int $herosId = 0;
    protected int $skillId = 0;
    protected bool $expertise = false;

    public function getHeros(): ?RpgHeros
    {
        $objDao = new RepositoryRpgHeros($this->qb, $this->qe);
        return $objDao->find($this->herosId);
    }

    public function getSkill(): ?RpgSkill
    {
        $objDao = new RepositoryRpgSkill($this->qb, $this->qe);
        return $objDao->find($this->skillId);
    }
}
