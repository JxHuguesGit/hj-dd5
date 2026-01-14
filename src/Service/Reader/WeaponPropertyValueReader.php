<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\WeaponPropertyValue as DomainWeaponPropertyValue;
use src\Repository\WeaponPropertyValue as RepositoryWeaponPropertyValue;

final class WeaponPropertyValueReader
{
    public function __construct(
        private RepositoryWeaponPropertyValue $wpnPropValueRepository
    ) {}
    
    public function getAllWeaponPropertyValues(array $orderBy=[]): Collection
    {
        return $this->wpnPropValueRepository->findAll($orderBy);
    }

    public function getWeaponPropertyValue(int $id): ?DomainWeaponPropertyValue
    {
        return $this->wpnPropValueRepository->find($id);
    }
}
