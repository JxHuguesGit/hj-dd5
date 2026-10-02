<?php
namespace src\Service\Writer;

use src\Domain\Entity\Spell;
use src\Repository\SpellRepositoryInterface;

class SpellWriter
{
    public function __construct(
        private SpellRepositoryInterface $repository
    ) {}

    public function insert(Spell $spell): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->insert($spell);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function updatePartial(Spell $spell, array $changedFields): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->updatePartial($spell, $changedFields);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
