<?php
namespace src\Service\Writer;

use src\Domain\Entity\Feat;
use src\Repository\FeatRepositoryInterface;

class FeatWriter
{
    public function __construct(
        private FeatRepositoryInterface $repository
    ) {}

    public function updatePartial(Feat $feat, array $changedFields): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->updatePartial($feat, $changedFields);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
