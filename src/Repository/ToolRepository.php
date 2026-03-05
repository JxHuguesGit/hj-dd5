<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field as F;
use src\Constant\Table;
use src\Domain\Entity\Tool;
use src\Domain\Criteria\ToolCriteria;

class ToolRepository extends Repository implements ToolRepositoryInterface
{
    public const TABLE = Table::TOOL;

    public function getEntityClass(): string
    {
        return Tool::class;
    }

    /**
     * @return ?Tool
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Tool
    {
        return parent::find($id);
    }

    /**
     * @return ?Tool
     */
    public function findWithRelations(int $id): ?Tool
    {
        $criteria = new ToolCriteria();
        $criteria->id = $id;
        return $this->findAllWithRelations($criteria)->first() ?? null;
    }

    /**
     * @return Collection<Tool>
     */
    public function findAllWithRelations(ToolCriteria $criteria): Collection
    {
        $baseQuery = "
            SELECT i.".F::ID." as ".F::ID.", ".F::PARENTID."
                , ".F::NAME.", ".F::SLUG.", ".F::WEIGHT.", ".F::GOLDPRICE."
            FROM " . Table::TOOL . " t
            INNER JOIN " . Table::ITEM . " i ON i.id = t.id
        ";

        $filters = [];
        if ($criteria->id !== null) {
            $filters['i.'.F::ID] = $criteria->id;
        }
        if ($criteria->type !== null) {
            $filters[F::TYPE] = $criteria->type;
        }

        $this->query = $this->queryBuilder->reset()
            ->setBaseQuery($baseQuery)
            ->where($filters)
            ->orderBy($criteria->orderBy)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $this->queryBuilder->getParams()
        );
    }

}
