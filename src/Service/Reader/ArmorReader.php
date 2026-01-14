<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Armor as DomainArmor;
use src\Repository\ArmorRepositoryInterface;

final class ArmorReader
{
    public function __construct(
        private ArmorRepositoryInterface $armorRepository
    ) {}
    
    /**
     * @return Collection<DomainArmor>
     */
    public function allArmors(): Collection
    {
        $orderBy = [
            Field::ARMORTYPID=>Constant::CST_ASC,
            Field::ARMORCLASS=>Constant::CST_ASC,
            Field::NAME=>Constant::CST_ASC,
        ];
        return $this->armorRepository->findByCategory($orderBy);
    }
    
    public function armorById(int $id): ?DomainArmor
    {
        return $this->armorRepository->find($id);
    }
}
