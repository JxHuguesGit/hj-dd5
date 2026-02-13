<?php
namespace src\Domain\Criteria;

use src\Query\QueryBuilder;

abstract class BaseCriteria extends AbstractCriteria implements CriteriaInterface
{
    public ?int $limit = -1;
    public ?int $offset = 0;
    public array $orderBy = [];

    /**
     * Méthode utilitaire pour appliquer automatiquement
     * limit / offset / orderBy si le QueryBuilder le supporte.
     *
     * Cette méthode n'est pas obligatoire à appeler dans les Criteria,
     * car Repository::findAllByCriteria() gère déjà limit/offset/orderBy.
     * Mais elle reste disponible si un Criteria veut surcharger le comportement.
     */
    protected function applyCommon(QueryBuilder $qb): void
    {
        if ($this->orderBy) {
            $qb->orderBy($this->orderBy);
        }

        if ($this->limit !== -1) {
            $qb->limit($this->limit, $this->offset ?? 0);
        }
    }
}
