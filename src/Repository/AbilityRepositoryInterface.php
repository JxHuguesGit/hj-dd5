<?php
namespace src\Repository;

use src\Domain\Ability as DomainAbility;
use src\Collection\Collection;

interface AbilityRepositoryInterface
{
    /**
     * @return ?DomainAbility
     */
    public function find(int $id): ?DomainAbility;
}
