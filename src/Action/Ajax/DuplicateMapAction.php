<?php
namespace src\Action\Ajax;

use src\Factory\ServiceFactory;

final class DuplicateMapAction
{
    public function __construct(
        private ServiceFactory $serviceFactory,
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

        $map = $this->serviceFactory->map()->duplicate($mapId);

        return [
            'mapId' => $map->id,
        ];
    }
}
