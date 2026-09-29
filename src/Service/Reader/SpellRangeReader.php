<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\SpellRangeCriteria;
use src\Domain\Entity\SpellRange;
use src\Repository\SpellRangeRepositoryInterface;

final class SpellRangeReader
{
    public function __construct(
        private SpellRangeRepositoryInterface $repository
    ) {}

    /**
     * @return ?SpellRange
     */
    public function spellrangeById(int $id): ?SpellRange
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<SpellRange>
     */
    public function allSpellRanges(?SpellRangeCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new SpellRangeCriteria();
            $criteria->orderBy = [F::NAME => C::ASC];
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
