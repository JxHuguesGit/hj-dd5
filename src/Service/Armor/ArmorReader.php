<?php
namespace src\Service\Armor;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Armor as DomainArmor;
use src\Repository\Armor as RepositoryArmor;

final class ArmorReader
{
    public function __construct(
        private RepositoryArmor $armorRepository
    ) {}
    
    public function getAllArmors(): Collection
    {
        $orderBy = [
            Field::ARMORTYPID=>Constant::CST_ASC,
            Field::ARMORCLASS=>Constant::CST_ASC,
            Field::NAME=>Constant::CST_ASC,
        ];
        return $this->armorRepository->findByCategory($orderBy);
    }
    
    public function getArmor(int $id): ?DomainArmor
    {
        return $this->armorRepository->find($id);
    }
}
