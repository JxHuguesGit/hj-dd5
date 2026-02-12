<?php
namespace src\Repository;

use src\Domain\Entity\Reference;

interface ReferenceRepositoryInterface
{
    /**
     * @return ?Reference
     */
    public function find(int $id): ?Reference;
}
