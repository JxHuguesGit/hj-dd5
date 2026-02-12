<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
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
     * @return Collection<Monster>
     */
    public function findAllWithCriteria(
        MonsterCriteria $criteria
    ): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

    /**
     * @return Collection<DomainArmor>
     */
    public function findAllWithJoint(
        MonsterCriteria $criteria
    ): Collection
    {
        $baseQuery = "
            SELECT m.id, m.".Field::NAME.", ".Field::FRNAME.", ".Field::FRTAG.", ".Field::UKTAG.", ".Field::INCOMPLET.", ".Field::SCORECR
                . ", ".Field::SWARMSIZE.", ".Field::MSTSIZE.", ".Field::SCORECA.", ".Field::SCOREHP.", ".Field::SPEED.", ".Field::INITIATIVE
                . ", ".Field::LEGENDARY.", ".Field::HABITAT.", ".Field::STRSCORE.", ".Field::DEXSCORE.", ".Field::CONSCORE.", ".Field::INTSCORE
                . ", ".Field::WISSCORE.", ".Field::CHASCORE.", ".Field::PROFBONUS.", ".Field::PERCPASSIVE.", ".Field::EXTRA
                . ", tm.".Field::NAME." AS ".Field::TYPMSTNAME.", ".Field::ABBR
                . ", stm.".Field::NAME." AS ".Field::SSTYPMSTNAME
                . ", r.".Field::NAME." AS ".Field::REFNAME
            . " FROM " . Table::MONSTER . " m
            INNER JOIN " . Table::TYPEMONSTRE . " tm ON tm.id = ".Field::MSTTYPEID."
            LEFT JOIN " . Table::SSTYPEMONSTRE . " stm ON stm.id = ".Field::MSTSSTYPID."
            INNER JOIN " . Table::ALIGNMENT . " a ON a.id = ".Field::ALGNID."
            LEFT JOIN " . Table::REFERENCE . " r ON r.id = ".Field::REFID."
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
