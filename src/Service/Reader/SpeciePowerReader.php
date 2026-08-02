<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\SpeciePowerCriteria;
use src\Domain\Entity\SpeciePower;
use src\Repository\SpeciePowerRepositoryInterface;

final class SpeciePowerReader
{
    public function __construct(
        private SpeciePowerRepositoryInterface $repository
    ) {}

    /**
     * @return ?SpeciePower
     */
    public function speciePowerById(int $id): ?SpeciePower
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<SpeciePower>
     */
    public function speciePowerBySpecie(int $speciesId): Collection
    {
        $criteria            = new SpeciePowerCriteria();
        $criteria->speciesId = $speciesId;
        return $this->repository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<SpeciePower>
     */
    public function speciePowerByPower(int $powerId): Collection
    {
        $criteria            = new SpeciePowerCriteria();
        $criteria->powerId = $powerId;
        return $this->repository->findAllWithCriteria($criteria);
    }
}
