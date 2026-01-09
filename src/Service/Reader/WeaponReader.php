<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Weapon as DomainWeapon;
use src\Repository\Weapon as RepositoryWeapon;

final class WeaponReader
{
    public function __construct(
        private RepositoryWeapon $weaponRepository
    ) {}
    
    public function getAllWeapons(): Collection
    {
        $orderBy = [
            Field::WPNCATID=>Constant::CST_ASC,
            Field::WPNRANGEID=>Constant::CST_ASC,
            Field::NAME=>Constant::CST_ASC,
        ];
        return $this->weaponRepository->findByCategory($orderBy);
    }
    
    public function getWeapon(int $id): ?DomainWeapon
    {
        return $this->weaponRepository->find($id);
    }
}
