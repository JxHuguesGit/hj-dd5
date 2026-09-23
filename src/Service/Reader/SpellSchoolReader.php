<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\SpellSchoolCriteria;
use src\Domain\Entity\SpellSchool;
use src\Repository\SpellSchoolRepositoryInterface;

final class SpellSchoolReader
{
    public function __construct(
        private SpellSchoolRepositoryInterface $repository
    ) {}

    /**
     * @return ?SpellSchool
     */
    public function spellschoolById(int $id): ?SpellSchool
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<SpellSchool>
     */
    public function allSpellSchools(?SpellSchoolCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new SpellSchoolCriteria();
            $criteria->orderBy = [F::NAME => C::ASC];
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
