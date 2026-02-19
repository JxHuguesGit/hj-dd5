<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
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
            $criteria->orderBy = [Field::ID=>Constant::CST_ASC];
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
