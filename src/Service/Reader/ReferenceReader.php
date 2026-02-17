<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Criteria\ReferenceCriteria;
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
    
    /**
     * @return Collection<Reference>
     */
    public function allReferences(array $orderBy=[Field::NAME => Constant::CST_ASC]): Collection
    {
        $criteria = new ReferenceCriteria();
        $criteria->orderBy = $orderBy;
        return $this->repository->findAllWithCriteria($criteria);
    }
}
