<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Power as DomainPower;
use src\Repository\PowerRepositoryInterface;

final class PowerReader
{
    public function __construct(
        private PowerRepositoryInterface $powerRepository
    ) {}
    
    /**
     * @return Collection<DomainPower>
     */
    public function allPowers(): Collection
    {
        return $this->powerRepository->findAll();
    }
    
    public function powerById(int $id): ?DomainPower
    {
        return $this->powerRepository->find($id);
    }
}
