<?php
namespace src\Service\Reader;

use src\Domain\Entity\MonsterSubType;
use src\Repository\MonsterSubTypeRepositoryInterface;

final class MonsterSubTypeReader
{
    public function __construct(
        private MonsterSubTypeRepositoryInterface $repository,
    ) {}

    /**
     * @return ?MonsterSubType
     */
    public function monsterSubTypeById(int $id): ?MonsterSubType
    {
        return $this->repository->find($id);
    }
}
