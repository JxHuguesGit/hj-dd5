<?php
namespace src\Service\Reader;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Collection\Collection;
use src\Domain\Criteria\InitiativeCriteria;
use src\Domain\Entity\Initiative;
use src\Repository\InitiativeRepositoryInterface;

final class InitiativeReader
{
    public function __construct(
        private InitiativeRepositoryInterface $initiativeRepository,
    ) {}

    /**
     * @return ?Initiative
     */
    public function initiativeById(int $id): ?Initiative
    {
        return $this->initiativeRepository->find($id);
    }

    /**
     * @return Collection<Initiative>
     */
    public function initiativesByMap(int $mapId): Collection
    {
        $criteria = new InitiativeCriteria();
        $criteria->mapId = $mapId;
        return $this->initiativeRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return ?Initiative
     */
    public function activeInitiativeByMap(int $mapId): ?Initiative
    {
        return $this->initiativeRepository->find($mapId);
    }

    /**
     * @return ?Initiative
     */
    public function nextInitiativeByMap(int $mapId): ?Initiative
    {
        return $this->initiativeRepository->find($mapId);
    }
}
