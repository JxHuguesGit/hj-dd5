<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field as F;
use src\Constant\Table;
use src\Domain\Criteria\SkillCriteria;
use src\Domain\Entity\Skill;
use src\Query\QueryBuilder;

class SkillRepository extends Repository implements SkillRepositoryInterface
{
    public const TABLE = Table::SKILL;

    public function getEntityClass(): string
    {
        return Skill::class;
    }

    /**
     * @return ?Skill
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Skill
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Skill>
     */
    public function findAllWithCriteria(SkillCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

    /**
     * @return Collection<Skill>
     */
    public function findAllWithRelations(SkillCriteria $criteria): Collection
    {
        $baseQuery = "
            SELECT s." . F::ID . ", s." . F::ABILITYID . ", s." . F::WPPOSTID . ",
                s." . F::PARENTID . ",
                wp.post_title AS " . F::NAME . ", wp.post_name AS " . F::SLUG . ", wp.post_content AS " . F::DESCRIPTION . "
            FROM " . Table::SKILL . " s
            LEFT JOIN " . Table::WPPOST . " wp
                ON s." . F::WPPOSTID . " = wp.ID
        ";

        $queryBuilder = new QueryBuilder();
        $queryBuilder->setBaseQuery($baseQuery);
        $criteria->apply($queryBuilder);

        $this->query = $queryBuilder->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $queryBuilder->getParams()
        );
    }
}
