<?php
namespace src\Repository;

use src\Domain\Armor as DomainArmor;
use src\Collection\Collection;

interface ArmorRepositoryInterface
{
    public function find(int $id): ?DomainArmor;
    public function findAll(): Collection;
}
