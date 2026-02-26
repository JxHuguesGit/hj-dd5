<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Criteria\DamageTypeCriteria;
use src\Domain\Entity\DamageType;
use src\Repository\DamageTypeRepositoryInterface;

final class DamageTypeReader
{
    public function __construct(
        private DamageTypeRepositoryInterface $repository
    ) {}

    /**
     * @return ?DamageType
     */
    public function damageTypeById(int $id): ?DamageType
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<DamageType>
     */
    public function allDamageTypes(?DamageTypeCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria          = new DamageTypeCriteria();
            $criteria->orderBy = [Field::NAME => Constant::CST_ASC];
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
