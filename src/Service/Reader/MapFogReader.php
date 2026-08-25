<?php
namespace src\Service\Reader;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Collection\Collection;
use src\Domain\Criteria\MapFogCriteria;
use src\Domain\Entity\MapFog;
use src\Repository\MapFogRepositoryInterface;

final class MapFogReader
{
    public function __construct(
        private MapFogRepositoryInterface $mapFogRepository,
    ) {}

    /**
     * @return ?MapFog
     */
    public function mapFogById(int $id): ?MapFog
    {
        return $this->mapFogRepository->find($id);
    }

    /**
     * @return Collection<MapFog>
     */
    public function mapFogsByMap(int $mapId): Collection
    {
        $criteria = new MapFogCriteria();
        $criteria->mapId = $mapId;
        return $this->mapFogRepository->findAllWithCriteria($criteria);
    }
}
