<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Power as DomainPower;
use src\Repository\Power as RepositoryPower;

final class PowerReader
{
    public function __construct(
        private RepositoryPower $powerRepository
    ) {}
    
    public function getAllPowers(): Collection
    {
        return $this->powerRepository->findAll();
    }
    
    public function getPower(int $id): ?DomainPower
    {
        return $this->powerRepository->find($id);
    }
}
