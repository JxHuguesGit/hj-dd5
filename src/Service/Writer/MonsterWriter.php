<?php

namespace src\Service\Writer;

use src\Domain\Monster\Monster;
use src\Repository\MonsterRepositoryInterface;

class MonsterWriter
{
    public function __construct(
        private MonsterRepositoryInterface $monsterRepository
    ) {}

    public function update(array $data): void
    {
        $this->monsterRepository->beginTransaction();

        try {

            $this->monsterRepository->updateMonster($data);
            $this->monsterRepository->syncSpeeds($data);

            $this->monsterRepository->commit();
        } catch (\Throwable $e) {

            $this->monsterRepository->rollBack();
            throw $e;
        }
    }

    public function updatePartial(Monster $monster, array $changedFields): void
    {
        $this->monsterRepository->beginTransaction();
        try {
            $this->monsterRepository->updatePartial($monster, $changedFields);
            $this->monsterRepository->commit();
        } catch (\Throwable $e) {
            $this->monsterRepository->rollBack();
            throw $e;
        }
    }
}
