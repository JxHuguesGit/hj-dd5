<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\SpellCastingTimeCriteria;
use src\Domain\Entity\SpellCastingTime;
use src\Repository\SpellCastingTimeRepositoryInterface;

final class SpellCastingTimeReader
{
    public function __construct(
        private SpellCastingTimeRepositoryInterface $repository
    ) {}

    /**
     * @return ?SpellCastingTime
     */
    public function spellcastingTimeById(int $id): ?SpellCastingTime
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<SpellCastingTime>
     */
    public function allSpellCastingTimes(?SpellCastingTimeCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new SpellCastingTimeCriteria();
            $criteria->orderBy = [F::NAME => C::ASC];
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
