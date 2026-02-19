<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\CharacterCreation\CharacterDraft;
use src\Domain\Criteria\CharacterDraftCriteria;

class CharacterDraftRepository extends Repository implements CharacterDraftRepositoryInterface
{
    public const TABLE = Table::CHARACTERDRAFT;

    public function getEntityClass(): string
    {
        return CharacterDraft::class;
    }

    /**
     * @return ?CharacterDraft
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?CharacterDraft
    {
        return parent::find($id);
    }

    /**
     * @return Collection<CharacterDraft>
     */
    public function findAllWithCriteria(CharacterDraftCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
