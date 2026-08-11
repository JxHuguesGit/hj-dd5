<?php
namespace src\Action\Ajax;

use src\Exception\MapNotFoundException;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;

final class UnlockMapAction
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
    ) {}

    public function execute(): array
    {
        $mapId = (int) filter_input(INPUT_POST, 'mapId');

        $map = $this->readerFactory->map()->mapById($mapId);

        if ($map === null) {
            throw new MapNotFoundException($mapId);
        }

        $this->serviceFactory->map()->unlock($map);

        return [];
    }
}
