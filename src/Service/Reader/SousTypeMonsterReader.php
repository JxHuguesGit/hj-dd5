<?php
namespace src\Service\Reader;

use src\Domain\Entity\SousTypeMonster;
use src\Repository\SousTypeMonsterRepositoryInterface;

final class SousTypeMonsterReader
{
    public function __construct(
        private SousTypeMonsterRepositoryInterface $repository,
    ) {}

    /**
     * @return ?SousTypeMonster
     */
    public function typeMonsterById(int $id): ?SousTypeMonster
    {
        return $this->repository->find($id);
    }
}
