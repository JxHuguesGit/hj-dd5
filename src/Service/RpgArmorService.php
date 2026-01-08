<?php
namespace src\Service;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\RpgArmor as DomainRpgArmor;
use src\Repository\RpgArmor as RepositoryRpgArmor;

final class RpgArmorService
{
    public function __construct(
        private RepositoryRpgArmor $armorRepository
    ) {}
    
    public function getAllArmors(): Collection
    {
        $orderBy = [
            Field::ARMORTYPID=>Constant::CST_ASC,
            Field::ARMORCLASS=>Constant::CST_ASC,
            Field::NAME=>Constant::CST_ASC,
        ];
        return $this->armorRepository->findByCategory('armor', $orderBy);
    }
    
    public function getArmor(int $id): ?DomainRpgArmor
    {
        return $this->armorRepository->find($id);
    }
}
