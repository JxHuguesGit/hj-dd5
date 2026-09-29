<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SpellComponentCriteria;
use src\Domain\Entity\SpellComponent;

class SpellComponentRepository extends Repository implements SpellComponentRepositoryInterface
{
    public const TABLE = Table::MATERIALCOMPONENT;

    public function getEntityClass(): string
    {
        return SpellComponent::class;
    }

    /**
     * @return ?SpellComponent
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?SpellComponent
    {
        return parent::find($id);
    }

    /**
     * @return Collection<SpellComponent>
     */
    public function findAllWithCriteria(SpellComponentCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
