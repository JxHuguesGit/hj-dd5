<?php
namespace App\Service\Writer;

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
}
