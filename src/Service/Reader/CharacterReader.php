<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Character\Character;
use src\Domain\Criteria\CharacterCriteria;
use src\Repository\CharacterRepositoryInterface;

final class CharacterReader
{
    public function __construct(
        private CharacterRepositoryInterface $repo,
    ) {}

    /**
     * @return ?Character
     */
    public function characterById(int $id): ?Character
    {
        return $this->repo->find($id);
    }

    /**
     * @return Collection<Character>
     */
    public function characterByWpUser(int $wpUserId): Collection
    {
        $criteria           = new CharacterCriteria();
        $criteria->wpUserId = $wpUserId;
        $criteria->orderBy  = [F::NAME => C::ASC];
        return $this->repo->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<Character>
     */
    public function allFeats(?CharacterCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria          = new CharacterCriteria();
            $criteria->orderBy = [F::NAME => C::ASC];
        }
        return $this->repo->findAllWithCriteria($criteria);
    }
}
