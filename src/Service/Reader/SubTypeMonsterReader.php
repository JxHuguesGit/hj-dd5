<?php
namespace src\Service\Reader;

use src\Domain\Entity\SubTypeMonster;
use src\Repository\SubTypeMonsterRepositoryInterface;

final class SubTypeMonsterReader
{
    public function __construct(
        private SubTypeMonsterRepositoryInterface $repository,
    ) {}

    /**
     * @return ?SubTypeMonster
     */
    public function typeMonsterById(int $id): ?SubTypeMonster
    {
        return $this->repository->find($id);
    }
}
