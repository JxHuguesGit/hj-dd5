<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Entity\Power;

class PowerRepository extends Repository implements PowerRepositoryInterface
{
    public const TABLE = Table::POWER;

    public function getEntityClass(): string
    {
        return Power::class;
    }

    /**
     * @return Power
     */
    public function find(int $id): Power
    {
        return parent::find($id) ?? new Power();
    }
}
