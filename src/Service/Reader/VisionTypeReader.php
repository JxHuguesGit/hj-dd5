<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\VisionTypeCriteria;
use src\Domain\Entity\VisionType;
use src\Repository\VisionTypeRepositoryInterface;

final class VisionTypeReader
{
    public function __construct(
        private VisionTypeRepositoryInterface $repository,
    ) {}

    /**
     * @return ?VisionType
     */
    public function visionTypeById(int $id): ?VisionType
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<VisionType>
     */
    public function allVisionTypes(?VisionTypeCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria          = new VisionTypeCriteria();
            $criteria->orderBy = [F::ID => C::ASC];
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
