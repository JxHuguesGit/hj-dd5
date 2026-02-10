<?php
namespace src\Repository;

use src\Domain\Entity\Power;

interface PowerRepositoryInterface
{
    /**
     * @return ?Power
     */
    public function find(int $id): ?Power;
}
