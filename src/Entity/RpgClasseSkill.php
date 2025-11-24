<?php
namespace src\Entity;

use src\Constant\Field;
use src\Repository\RpgClasse as RepositoryRpgClasse;
use src\Repository\RpgSkill as RepositoryRpgSkill;

class RpgClasseSkill extends Entity
{
    public const TABLE = 'rpgClasseSkill';
    public const FIELDS = [
        Field::ID,
        Field::CLASSEID,
        Field::SKILLID,
    ];
    public const FIELD_TYPES = [
        Field::CLASSEID => 'intPositive',
        Field::SKILLID => 'intPositive',
    ];

    protected int $classeId;
    protected int $skillId;
    
    public function getClasse(): ?RpgClasse
    {
        $objDao = new RepositoryRpgClasse($this->qb, $this->qe);
        return $objDao->find($this->classeId);
    }
    
    public function getSkill(): ?RpgSkill
    {
        $objDao = new RepositoryRpgSkill($this->qb, $this->qe);
        return $objDao->find($this->skillId);
    }
}
