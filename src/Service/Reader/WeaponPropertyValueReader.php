<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\WeaponPropertyValue as DomainWeaponPropertyValue;
use src\Repository\WeaponPropertyValueRepositoryInterface;

final class WeaponPropertyValueReader
{
    public function __construct(
        private WeaponPropertyValueRepositoryInterface $wpnPropValueRepository
    ) {}
    
    /**
     * @return Collection<DomainWeaponPropertyValue>
     */
    public function allWeaponPropertyValues(array $orderBy=[]): Collection
    {
        return $this->wpnPropValueRepository->findAll($orderBy);
    }

    /**
     * @return Collection<DomainWeaponPropertyValue>
     */
    public function byWeaponId(int $weaponId): Collection
    {
        return $this->wpnPropValueRepository->byWeaponId($weaponId);
    }

    public function weaponPropertyValueById(int $id): ?DomainWeaponPropertyValue
    {
        return $this->wpnPropValueRepository->find($id);
    }
}
