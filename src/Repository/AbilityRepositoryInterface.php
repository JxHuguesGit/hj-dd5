<?php
namespace src\Repository;

use src\Domain\Entity\Ability;

interface AbilityRepositoryInterface
{
    /**
     * @return ?Ability
     */
    public function find(int $id): ?Ability;
}
