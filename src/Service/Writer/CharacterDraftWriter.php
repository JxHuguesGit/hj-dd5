<?php
namespace src\Service\Writer;

use src\Domain\CharacterCreation\CharacterDraft;
use src\Repository\CharacterDraftRepositoryInterface;

class CharacterDraftWriter
{
    public function __construct(
        private CharacterDraftRepositoryInterface $repository
    ) {}

    public function save(CharacterDraft $draft)
    {
        if ($draft->id==0) {
            $this->repository->insert($draft);
        } else {
            $this->repository->update($draft);
        }
    }

    public function updatePartial(CharacterDraft $draft, array $changedFields): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->updatePartial($draft, $changedFields);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
