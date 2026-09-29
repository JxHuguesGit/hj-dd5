<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\SpellDurationCriteria;
use src\Domain\Entity\SpellDuration;
use src\Repository\SpellDurationRepositoryInterface;

final class SpellDurationReader
{
    public function __construct(
        private SpellDurationRepositoryInterface $repository
    ) {}

    /**
     * @return ?SpellDuration
     */
    public function spelldurationById(int $id): ?SpellDuration
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<SpellDuration>
     */
    public function allSpellDurations(?SpellDurationCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new SpellDurationCriteria();
            $criteria->orderBy = [F::NAME => C::ASC];
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
