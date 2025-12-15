<?php
namespace src\Service;

use src\Collection\Collection;
use src\Domain\RpgAbility as DomainRpgAbility;
use src\Repository\RpgAbility as RepositoryRpgAbility;

final class RpgAbilityQueryService
{
    public function __construct(
        private RepositoryRpgAbility $abilityRepository
    ) {}
    
    public function getAllAbilities(): Collection
    {
        return $this->abilityRepository->findAll();
    }
    
    public function getAbility(int $id): ?DomainRpgAbility
    {
        return $this->abilityRepository->find($id);
    }
}
