<?php
namespace src\Repository;

use src\Domain\Power as DomainPower;

class Power extends Repository
{
    public function getEntityClass(): string
    {
        return DomainPower::class;
    }
}
