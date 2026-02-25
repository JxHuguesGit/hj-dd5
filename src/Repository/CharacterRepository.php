<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Character\Character;
use src\Domain\Criteria\CharacterCriteria;

class CharacterRepository extends Repository implements CharacterRepositoryInterface
{
    public const TABLE = Table::CHARACTER;

    public function getEntityClass(): string
    {
        return Character::class;
    }

    /**
     * @return ?Character
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Character
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Character>
     */
    public function findAllWithCriteria(CharacterCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
