<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\MapTokenCriteria;
use src\Domain\Entity\MapToken;
use src\Repository\MapTokenRepositoryInterface;

final class MapTokenReader
{
    public function __construct(
        private MapTokenRepositoryInterface $mapTokenRepository,
    ) {}

    /**
     * @return ?MapToken
     */
    public function mapTokenById(int $id): ?MapToken
    {
        return $this->mapTokenRepository->find($id);
    }

    /**
     * @return Collection<MapToken>
     */
    public function mapTokensByMap(int $mapId): Collection
    {
        $criteria = new MapTokenCriteria();
        $criteria->mapId = $mapId;
        return $this->mapTokenRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<MapToken>
     */
    public function allMapTokens(?MapTokenCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new MapTokenCriteria();
        }
        return $this->mapTokenRepository->findAllWithCriteria($criteria);
    }
}
