<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SpellClasseCriteria;
use src\Domain\Entity\SpellClasse;

class SpellClasseRepository extends Repository implements SpellClasseRepositoryInterface
{
    public const TABLE = Table::SPELLCLASSE;

    public function getEntityClass(): string
    {
        return SpellClasse::class;
    }

    /**
     * @return Collection<SpellClasse>
     */
    public function findAllWithCriteria(SpellClasseCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
