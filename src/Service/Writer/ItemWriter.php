<?php
namespace src\Service\Writer;

use src\Domain\Entity\Item;
use src\Repository\ItemRepositoryInterface;

class ItemWriter
{
    public function __construct(
        private ItemRepositoryInterface $repository
    ) {}

    public function insert(Item $item): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->insert($item);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function updatePartial(Item $item, array $changedFields): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->updatePartial($item, $changedFields);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
