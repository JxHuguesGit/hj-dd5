<?php
namespace src\Service\Writer;

use src\Domain\Character\Character;
use src\Repository\CharacterRepositoryInterface;

class CharacterWriter
{
    public function __construct(
        private CharacterRepositoryInterface $repository
    ) {}

    public function save(Character $character)
    {
        if ($character->id === null) {
            $this->repository->insert($character);
        } else {
            $this->repository->update($character);
        }
    }

    public function updatePartial(Character $character, array $changedFields): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->updatePartial($character, $changedFields);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
