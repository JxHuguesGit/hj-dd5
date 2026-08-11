<?php
namespace src\Action\Ajax;

use src\Service\Domain\MapService;

final class ActivateMapAction
{
    public function __construct(
        private MapService $mapService
    ) {}

    public function execute(): array
    {
        $mapId = filter_input(
            INPUT_POST,
            'mapId',
            FILTER_VALIDATE_INT
        );

        if ($mapId === false || $mapId === null) {
            throw new \InvalidArgumentException(
                'Identifiant de map invalide.'
            );
        }

        $this->mapService->activate($mapId);

        return [];
    }
}
