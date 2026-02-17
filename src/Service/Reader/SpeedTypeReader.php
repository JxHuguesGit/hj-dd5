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
    public function allSpeedTypes(array $orderBy=[Field::NAME => Constant::CST_ASC]): Collection
    {
        $criteria = new SpeedTypeCriteria();
        $criteria->orderBy = $orderBy;
        return $this->repository->findAllWithCriteria($criteria);
    }
}
