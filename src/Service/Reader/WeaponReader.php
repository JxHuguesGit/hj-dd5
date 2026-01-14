<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
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
        $orderBy = [
            Field::WPNCATID=>Constant::CST_ASC,
            Field::WPNRANGEID=>Constant::CST_ASC,
            Field::NAME=>Constant::CST_ASC,
        ];
        return $this->weaponRepository->findByCategory($orderBy);
    }
    
    public function weaponById(int $id): ?DomainWeapon
    {
        return $this->weaponRepository->find($id);
    }
}
