<?php
namespace src\Action\Ajax;

use src\Constant\Field as F;
use src\Domain\Entity\MapToken;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory as WF;

final class DeleteMapTokenAction
{
    public function __construct(
        private WF $writerFactory,
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
    ) {}

    public function execute(): array
    {
        $tokenId = filter_input(INPUT_POST, 'tokenId');

        $mapToken = new MapToken([
            F::ID      => $tokenId,
        ]);

        $map = $this->readerFactory->map()->mapById($mapToken->id);
        if ($map === null) {
            throw new \RuntimeException('Map introuvable.');
        }
        $this->serviceFactory->map()->assertUnlocked($map);

        $this->writerFactory->mapToken()->delete($mapToken);

        return ['status' => 'success'];
    }
}
