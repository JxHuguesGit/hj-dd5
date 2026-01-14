<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Ability as DomainAbility;
use src\Repository\AbilityRepositoryInterface;

final class AbilityReader
{
    public function __construct(
        private AbilityRepositoryInterface $abilityRepository
    ) {}
    
    /**
     * @return Collection<DomainAbility>
     */
    public function allAbilities(): Collection
    {
        return $this->abilityRepository->findAll();
    }
    
    public function abilityById(int $id): ?DomainAbility
    {
        return $this->abilityRepository->find($id);
    }
}
