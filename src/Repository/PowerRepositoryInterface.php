<?php
namespace src\Repository;

use src\Domain\Power as DomainPower;
use src\Collection\Collection;

interface PowerRepositoryInterface
{
    /**
     * @return ?DomainPower
     */
    public function find(int $id): ?DomainPower;
}
