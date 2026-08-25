<?php
namespace src\Action\Ajax;

use src\Constant\Constant as C;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;

final class LoadMapTokensAction
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
    ) {}

    public function execute(array $params): array
    {
        $map = $this->readerFactory->map()->mapById($params[C::MAPID]);
        $mapFogService = $this->serviceFactory->mapFog();
        $mapFogService->updateVisibility($map);

        return [
            'tokens' => $this->serviceFactory
                ->mapToken()
                ->buildTokens($params[C::MAPID]),
            'visibleCells' => $mapFogService->getVisibleCells($map),
            'discoveredCells' => $mapFogService->getDiscoveredCells($map),
        ];
    }
}
