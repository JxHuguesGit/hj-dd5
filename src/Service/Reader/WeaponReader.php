<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\WeaponCriteria;
use src\Domain\Weapon as DomainWeapon;
use src\Repository\WeaponRepositoryInterface;

final class WeaponReader
{
    public function __construct(
        private WeaponRepositoryInterface $weaponRepository
    ) {}
    
    /**
     * @return Collection<DomainWeapon>
     */
    public function allWeapons(): Collection
    {
        return $this->weaponRepository->findAllWithItemAndType(new WeaponCriteria());
    }
}
