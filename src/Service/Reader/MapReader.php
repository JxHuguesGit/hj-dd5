<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\MapCriteria;
use src\Domain\Entity\Map;
use src\Repository\MapRepositoryInterface;

final class MapReader
{
    public function __construct(
        private MapRepositoryInterface $mapRepository,
    ) {}

    /**
     * @return ?Map
     */
    public function mapById(int $id): ?Map
    {
        return $this->mapRepository->find($id);
    }

    /**
     * @return Collection<Map>
     */
    public function allMaps(?MapCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new MapCriteria();
        }
        return $this->mapRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return ?Map
     */
    public function getActiveMap(): ?Map
    {
        $mapCriteria = new MapCriteria();
        $mapCriteria->active = 1;

        $collection = $this->allMaps($mapCriteria);
        return !$collection->isEmpty() ? $collection->first() : null;
    }
}
