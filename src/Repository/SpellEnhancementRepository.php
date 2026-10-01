<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SpellEnhancementCriteria;
use src\Domain\Entity\SpellEnhancement;

class SpellEnhancementRepository extends Repository implements SpellEnhancementRepositoryInterface
{
    public const TABLE = Table::SPELLENHANCEMENT;

    public function getEntityClass(): string
    {
        return SpellEnhancement::class;
    }

    /**
     * @return ?SpellEnhancement
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?SpellEnhancement
    {
        return parent::find($id);
    }

    /**
     * @return Collection<SpellEnhancement>
     */
    public function findAllWithCriteria(SpellEnhancementCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
