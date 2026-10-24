<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\ITCharacterCriteria;
use src\Domain\Entity\ITCharacter;

final class InitTrackCharacterRepository extends Repository implements InitTrackCharacterRepositoryInterface
{
    public const TABLE = Table::ITCHARACTER;
    
    public function getEntityClass(): string
    {
        return ITCharacter::class;
    }

    /**
     * @return ?ITCharacter
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?ITCharacter
    {
        return parent::find($id);
    }

    /**
     * @return Collection<ITCharacter>
     */
    public function findAllWithCriteria(ITCharacterCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
