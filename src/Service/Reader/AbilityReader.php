<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Ability as DomainAbility;
use src\Repository\Ability as RepositoryAbility;

final class AbilityReader
{
    public function __construct(
        private RepositoryAbility $abilityRepository
    ) {}
    
    public function getAllAbilities(): Collection
    {
        return $this->abilityRepository->findAll();
    }
    
    public function getAbility(int $id): ?DomainAbility
    {
        return $this->abilityRepository->find($id);
    }
}
