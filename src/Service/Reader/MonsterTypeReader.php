<?php
namespace src\Service\Reader;

use src\Domain\Entity\MonsterType;
use src\Repository\MonsterTypeRepositoryInterface;

final class MonsterTypeReader
{
    public function __construct(
        private MonsterTypeRepositoryInterface $repository,
    ) {}

    /**
     * @return ?MonsterType
     */
    public function monsterTypeById(int $id): ?MonsterType
    {
        return $this->repository->find($id);
    }
}
