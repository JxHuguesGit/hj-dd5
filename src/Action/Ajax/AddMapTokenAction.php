<?php
namespace src\Action\Ajax;

use src\Constant\Field as F;
use src\Domain\Entity\MapToken;
use src\Exception\MapNotFoundException;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory as WF;

final class AddMapTokenAction
{
    public function __construct(
        private WF $writerFactory,
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory
    ) {}

    public function execute(): array
    {
        $mapId = filter_input(INPUT_POST, 'mapId');
        $tokenId = filter_input(INPUT_POST, 'tokenId');
        $column = filter_input(INPUT_POST, 'column');
        $row = filter_input(INPUT_POST, 'row');

        $map = $this->readerFactory->map()->mapById($mapId);
        if ($map === null) {
            throw new MapNotFoundException($mapId);
        }

        $this->serviceFactory->map()->assertUnlocked($map);

        $token = $this->readerFactory
            ->token()
            ->tokenById($tokenId);
        
        if (!$token) {
            return [
                'status' => 'error',
                'message' => 'Token inconnu.',
            ];
        }

        $number = $this->readerFactory
            ->mapToken()
            ->nextNumber($mapId, $tokenId);

        $mapToken = new MapToken([
            F::MAPID   => $mapId,
            F::TOKENID => $tokenId,
            F::COLUMN  => $column,
            F::ROW     => $row,
            F::SIZE    => $token->size,
            F::NUMBER  => $number,
        ]);

        $this->writerFactory->mapToken()->insert($mapToken);

        return ['status' => 'success'];
    }
}
