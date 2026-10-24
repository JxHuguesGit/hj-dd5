<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\ITCharacterCriteria;
use src\Domain\Entity\ITCharacter;

interface InitTrackCharacterRepositoryInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    public function insert(ITCharacter $itCharacter): void;
    public function delete(ITCharacter $itCharacter): void;
    public function updatePartial(ITCharacter $itCharacter, array $changedFields): void;

    /**
     * @return ?ITCharacter
     */
    public function find(int $id): ?ITCharacter;

    /**
     * @return Collection<ITCharacter>
     */
    public function findAllWithCriteria(ITCharacterCriteria $criteria): Collection;
}
