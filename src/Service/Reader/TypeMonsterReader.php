<?php
namespace src\Service\Reader;

use src\Domain\Entity\TypeMonster;
use src\Repository\TypeMonsterRepositoryInterface;

final class TypeMonsterReader
{
    public function __construct(
        private TypeMonsterRepositoryInterface $repository,
    ) {}

    /**
     * @return ?TypeMonster
     */
    public function typeMonsterById(int $id): ?TypeMonster
    {
        return $this->repository->find($id);
    }
}
