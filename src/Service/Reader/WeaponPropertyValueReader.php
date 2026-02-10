<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Domain\Criteria\WeaponPropertyValueCriteria;
use src\Domain\Entity\WeaponPropertyValue;
use src\Repository\WeaponPropertyValueRepositoryInterface;

final class WeaponPropertyValueReader
{
    public function __construct(
        private WeaponPropertyValueRepositoryInterface $wpnPropValueRepository
    ) {}

    /**
     * @return ?WeaponPropertyValue
     */
    public function weaponPropertyValueById(int $id): ?WeaponPropertyValue
    {
        return $this->wpnPropValueRepository->find($id);
    }
    
    /**
     * @return Collection<WeaponPropertyValue>
     */
    public function allWeaponPropertyValues(array $orderBy=[]): Collection
    {
        $criteria = new WeaponPropertyValueCriteria();
        $criteria->orderBy = $orderBy;
        return $this->wpnPropValueRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<WeaponPropertyValue>
     */
    public function byWeaponId(int $weaponId): Collection
    {
        $criteria = new WeaponPropertyValueCriteria();
        $criteria->weaponId = $weaponId;
        $criteria->orderBy  = ['wp.name'=>Constant::CST_ASC];
        return $this->wpnPropValueRepository->findAllWithCriteria($criteria);
    }
}
