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

    protected int $classeId = 0;
    protected int $skillId = 0;
    
    private ?RpgClasse $classeCache = null;
    private ?RpgSkill $skillCache = null;
    
    public function getClasse(): ?RpgClasse
    {
        return $this->getRelatedEntity('classeCache', RepositoryRpgClasse::class, $this->classeId);
    }

    public function getSkill(): ?RpgSkill
    {
        return $this->getRelatedEntity('skillCache', RepositoryRpgSkill::class, $this->skillId);
    }
}
