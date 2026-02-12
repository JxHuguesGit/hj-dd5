<?php
namespace src\Service\Reader;

use src\Domain\Entity\Reference;
use src\Repository\ReferenceRepositoryInterface;

final class ReferenceReader
{
    public function __construct(
        private ReferenceRepositoryInterface $repository
    ) {}
    
    /**
     * @return ?Reference
     */
    public function referenceById(int $id): ?Reference
    {
        return $this->repository->find($id);
    }
}
