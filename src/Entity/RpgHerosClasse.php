<?php
namespace src\Entity;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgClasse as RepositoryRpgClasse;

class RpgHerosClasse extends Entity
{
    public const TABLE = 'rpgHerosClasse';
    public const FIELDS = [
        Field::ID,
        Field::HEROSID,
        Field::CLASSEID,
        Field::NIVEAU,
    ];

    protected int $herosId;
    protected int $classeId;
    protected int $niveau;

    public function getClasse(): RpgClasse
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgClasse($queryBuilder, $queryExecutor);
        return $objDao->find($this->{Field::CLASSEID});
    }
}
