<?php
namespace src\Action\Ajax;

use src\Factory\ServiceFactory;

final class DeleteMapAction
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

        $this->serviceFactory->map()->delete($mapId);

        return [];
    }
}
