<?php
namespace src\Repository;

use src\Domain\Power as DomainPower;
use src\Collection\Collection;

interface PowerRepositoryInterface
{
    public function find(int $id): ?DomainPower;
    /**
     * @return Collection<DomainPower>
     */
    public function findAll(): Collection;
}
