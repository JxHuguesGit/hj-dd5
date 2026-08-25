<?php
namespace src\Service\Reader;

use src\Constant\Constant as C;
use src\Constant\Field as F;
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
        return $this->mapTokenRepository->findAllWithRelations($criteria);
    }

    /**
     * @return Collection<MapToken>
     */
    public function allMapTokens(?MapTokenCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new MapTokenCriteria();
        }
        return $this->mapTokenRepository->findAllWithRelations($criteria);
    }

    /**
     * @return Collection<MapToken>
     */
    public function pjTokensByMap(int $mapId): Collection
    {
        $criteria = new MapTokenCriteria();
        $criteria->mapId = $mapId;
        $criteria->type = 'character';

        return $this->mapTokenRepository->findAllWithRelations($criteria);
    }

    /**
     * @return int
     */
    public function nextNumber(int $mapId, int $tokenId): int
    {
        $criteria = new MapTokenCriteria();
        $criteria->mapId = $mapId;
        $criteria->tokenId = $tokenId;
        $criteria->orderBy = [F::NUMBER => C::DESC];

        $mapTokens = $this->allMapTokens($criteria);
        return $mapTokens->isEmpty() ? 1 : $mapTokens->first()->number + 1;
    }
}
