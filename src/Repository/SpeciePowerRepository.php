<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Entity\SpeciePower;

class SpeciePowerRepository extends Repository implements SpeciePowerRepositoryInterface
{
    public const TABLE = Table::SPECIEPOWER;

    public function getEntityClass(): string
    {
        return SpeciePower::class;
    }
}
