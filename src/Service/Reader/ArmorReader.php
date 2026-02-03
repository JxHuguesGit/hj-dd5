<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\ArmorCriteria;
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
        return $this->armorRepository->findAllWithItemAndType(new ArmorCriteria());
    }
}
