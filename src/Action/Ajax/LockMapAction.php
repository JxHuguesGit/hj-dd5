<?php
namespace src\Action\Ajax;

use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;

final class LockMapAction
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
            throw new \RuntimeException('Map introuvable.');
        }

        $this->serviceFactory->map()->lock($map);

        return [];
    }
}
