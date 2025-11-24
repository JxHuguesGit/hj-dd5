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

    public function getHeros(): ?RpgHeros
    {
        $objDao = new RepositoryRpgHeros($this->qb, $this->qe);
        return $objDao->find($this->herosId);
    }

    public function getClasse(): ?RpgClasse
    {
        $objDao = new RepositoryRpgClasse($this->qb, $this->qe);
        return $objDao->find($this->classeId);
    }
}
