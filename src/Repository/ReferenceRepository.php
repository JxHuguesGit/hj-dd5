<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Entity\Reference;

class ReferenceRepository extends Repository implements ReferenceRepositoryInterface
{
    public const TABLE = Table::REFERENCE;

    public function getEntityClass(): string
    {
        return Reference::class;
    }

    /**
     * @return ?Reference
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Reference
    {
        return parent::find($id);
    }
}
