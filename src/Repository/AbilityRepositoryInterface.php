<?php
namespace src\Repository;

use src\Domain\Ability as DomainAbility;
use src\Collection\Collection;

interface AbilityRepositoryInterface
{
    public function find(int $id): ?DomainAbility;
    /**
     * @return Collection<DomainAbility>
     */
    public function findAll(): Collection;
}
