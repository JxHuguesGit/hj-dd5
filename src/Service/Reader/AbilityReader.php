<?php
namespace src\Service\Reader;

use src\Domain\Entity\Ability;
use src\Repository\AbilityRepositoryInterface;

final class AbilityReader
{
    public function __construct(
        private AbilityRepositoryInterface $abilityRepository
    ) {}
    
    /**
     * @return ?Ability
     */
    public function abilityById(int $id): ?Ability
    {
        return $this->abilityRepository->find($id);
    }
}
