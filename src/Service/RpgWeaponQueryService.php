<?php
namespace src\Service;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\RpgWeapon as DomainRpgWeapon;
use src\Repository\RpgWeapon as RepositoryRpgWeapon;

final class RpgWeaponQueryService
{
    public function __construct(
        private RepositoryRpgWeapon $weaponRepository
    ) {}
    
    public function getAllWeapons(): Collection
    {
        $orderBy = [
            Field::WPNCATID=>Constant::CST_ASC,
            Field::WPNRANGEID=>Constant::CST_ASC,
            'i.name'=>Constant::CST_ASC,
        ];
        return $this->weaponRepository->findByCategory('weapon', $orderBy);
    }
    
    public function getWeapon(int $id): ?DomainRpgWeapon
    {
        return $this->weaponRepository->find($id);
    }
}
