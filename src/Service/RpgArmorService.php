<?php
namespace src\Service;

use src\Collection\Collection;
use src\Domain\RpgArmor as DomainRpgArmor;
use src\Repository\RpgArmor as RepositoryRpgArmor;

final class RpgArmorService
{
    public function __construct(
        private RepositoryRpgArmor $armorRepository
    ) {}
    
    public function getAllArmors(): Collection
    {
        return $this->armorRepository->findAll();
    }
    
    public function getArmor(int $id): ?DomainRpgArmor
    {
        return $this->armorRepository->find($id);
    }
}
