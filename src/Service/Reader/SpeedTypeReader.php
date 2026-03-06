<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\SpeedTypeCriteria;
use src\Domain\Entity\SpeedType;
use src\Repository\SpeedTypeRepositoryInterface;

final class SpeedTypeReader
{
    public function __construct(
        private SpeedTypeRepositoryInterface $repository,
    ) {}

    /**
     * @return ?SpeedType
     */
    public function speedTypeById(int $id): ?SpeedType
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<SpeedType>
     */
    public function allSpeedTypes(?SpeedTypeCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new SpeedTypeCriteria();
            $criteria->orderBy = [F::ID=>C::ASC];
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
