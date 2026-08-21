<?php
namespace src\Action\Ajax;

use src\Constant\Field as F;
use src\Exception\ForbiddenActionException;
use src\Exception\MapNotFoundException;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory as WF;
use src\Utils\Session;

final class ToggleMapTokenAction
{
    public function __construct(
        private WF $writerFactory,
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
    ) {}

    public function execute(): array
    {
        $tokenId = filter_input(INPUT_POST, 'tokenId');
        $isMj = Session::getWpUser()->data->ID !== '0';

        $mapToken = $this->readerFactory
            ->mapToken()
            ->mapTokenById($tokenId);
        if (!$isMj && !$mapToken->enablePjMove) {
            throw new ForbiddenActionException("L'utilisateur n'a pas le droit de modifier ce token.");
        }

        $map = $this->readerFactory
            ->map()
            ->mapById($mapToken->mapId);
        if ($map === null) {
            throw new MapNotFoundException($mapToken->mapId);
        }
        $this->serviceFactory->map()->assertUnlocked($map);

        $mapToken->active = $mapToken->active == 0 ? 1 : 0;

        $this->writerFactory
            ->mapToken()
            ->updatePartial(
                $mapToken,
                [
                    F::ACTIVE,
                ]
            );

        return [
            'mapToken' => $mapToken,
        ];
    }
}
