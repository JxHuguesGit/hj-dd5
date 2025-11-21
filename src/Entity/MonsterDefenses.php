<?php
namespace src\Entity;

use src\Collection\Collection;
use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMonsterResistance as RepositoryRpgMonsterResistance;
use src\Repository\RpgMonsterCondition as RepositoryRpgMonsterCondition;

class MonsterDefenses
{
    private int $monsterId;

    public function __construct(int $monsterId)
    {
        $this->monsterId = $monsterId;
    }

    public function getResistances(string $typeResistanceId): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();

        $repo = new RepositoryRpgMonsterResistance($queryBuilder, $queryExecutor);
        $params = [Field::TYPERESID => $typeResistanceId, Field::MONSTERID => $this->monsterId];
        $collection = $repo->findBy($params);

        // Si c’est le type "I" (immunité) on ajoute les conditions
        if ($typeResistanceId === 'I') {
            $repoCond = new RepositoryRpgMonsterCondition($queryBuilder, $queryExecutor);
            $paramsCond = [Field::MONSTERID => $this->monsterId];
            $collection->concat($repoCond->findBy($paramsCond));
        }

        return $collection;
    }

    public function getConditions(): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $repo = new RepositoryRpgMonsterCondition($queryBuilder, $queryExecutor);
        $params = [Field::MONSTERID => $this->monsterId];
        return $repo->findBy($params);
    }
}
