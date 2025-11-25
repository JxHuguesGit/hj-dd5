<?php
namespace src\Entity;

use src\Constant\Field;
use src\Repository\RpgClasse as RepositoryRpgClasse;
use src\Repository\RpgHeros as RepositoryRpgHeros;

class RpgHerosClasse extends Entity
{
    public const TABLE = 'rpgHerosClasse';
    public const FIELDS = [
        Field::ID,
        Field::HEROSID,
        Field::CLASSEID,
        Field::NIVEAU,
    ];

    public const FIELD_TYPES = [
        Field::HEROSID => 'intPositive',
        Field::CLASSEID => 'intPositive',
        Field::NIVEAU => 'intPositive',
    ];

    protected int $herosId = 0;
    protected int $classeId = 0;
    protected int $niveau = 0;

    private ?RpgHeros $herosCache = null;
    private ?RpgClasse $classeCache = null;

    public function getHeros(): ?RpgHeros
    {
        return $this->getRelatedEntity('herosCache', RepositoryRpgHeros::class, $this->herosId);
    }

    public function getClasse(): ?RpgClasse
    {
        return $this->getRelatedEntity('classeCache', RepositoryRpgClasse::class, $this->classeId);
    }
}
