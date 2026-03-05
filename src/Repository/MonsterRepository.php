<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field as F;
use src\Constant\Table;
use src\Domain\Criteria\MonsterCriteria;
use src\Domain\Monster\Monster;
use src\Query\QueryBuilder;

class MonsterRepository extends Repository implements MonsterRepositoryInterface
{
    public const TABLE = Table::MONSTER;

    public function getEntityClass(): string
    {
        return Monster::class;
    }

    /**
     * @return ?Monster
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Monster
    {
        return parent::find($id);
    }

    /**
     * @return ?Monster
     */
    public function findWithRelations(int $id): ?Monster
    {
        $criteria     = new MonsterCriteria();
        $criteria->id = $id;
        return $this->findAllWithRelations($criteria)->first() ?? null;
    }

    /**
     * @return Collection<Monster>
     */
    public function findAllWithRelations(MonsterCriteria $criteria): Collection
    {
        $baseQuery = "
            SELECT m.id, m." . F::NAME . ", " . F::FRNAME . ", " . F::FRTAG . ", " . F::UKTAG . ", "
        . F::INCOMPLET . ", " . F::SCORECR . ", " . F::SWARMSIZE . ", " . F::MSTSIZE . ", "
        . F::SCORECA . ", " . F::SCOREHP . ", " . F::INITIATIVE . ", " . F::LEGENDARY . ", "
        . F::HABITAT . ", " . F::STRSCORE . ", " . F::DEXSCORE . ", " . F::CONSCORE . ", "
        . F::INTSCORE . ", " . F::WISSCORE . ", " . F::CHASCORE . ", " . F::PROFBONUS . ", "
        . F::PERCPASSIVE . ", " . F::EXTRA
        . ", tm." . F::NAME . " AS " . F::TYPMSTNAME . ", " . F::ABBR . ", tm.id AS " . F::MSTTYPEID
        . ", stm." . F::NAME . " AS " . F::SSTYPMSTNAME
        . ", r." . F::NAME . " AS " . F::REFNAME
        . " FROM " . Table::MONSTER . " m
            INNER JOIN " . Table::TYPEMONSTRE . " tm ON tm.id = " . F::MSTTYPEID . "
            LEFT JOIN " . Table::SSTYPEMONSTRE . " stm ON stm.id = " . F::MSTSSTYPID . "
            INNER JOIN " . Table::ALIGNMENT . " a ON a.id = " . F::ALGNID . "
            LEFT JOIN " . Table::REFERENCE . " r ON r.id = " . F::REFID . "
        ";

        $queryBuilder = new QueryBuilder();
        $queryBuilder->setBaseQuery($baseQuery);
        $criteria->apply($queryBuilder);

        $this->query = $queryBuilder
            ->orderBy($criteria->orderBy)
            ->limit($criteria->limit, $criteria->offset)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $queryBuilder->getParams()
        );
    }
}
