<?php
namespace src\Action\Ajax;

use src\Constant\Field as F;
use src\Domain\Entity\MapToken;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory as WF;
use src\Utils\Session;

final class UpdateMapTokensAction
{
    public function __construct(
        private WF $writerFactory,
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
    ) {}

    public function execute(): array
    {
        $tokensJson = filter_input(INPUT_POST, 'tokens');

        $tokens = json_decode(
            $tokensJson,
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        foreach ($tokens as $data) {
            $tokenId = $data[F::ID];

            $mapToken = $this->readerFactory
                ->mapToken()
                ->mapTokenById($tokenId);
            $map = $this->readerFactory
                ->map()
                ->mapById($mapToken->mapId);
            if ($map === null) {
                throw new \RuntimeException('Map introuvable.');
            }
            $this->serviceFactory->map()->assertUnlocked($map);

            $token = new MapToken();
            $token->assignId($data[F::ID]);
            $token->column = (int) $data[F::COLUMN];
            $token->row = (int) $data[F::ROW];


            $this->writerFactory
                ->mapToken()
                ->updatePartial(
                    $token,
                    [
                        F::COLUMN,
                        F::ROW,
                    ]
                );
        }

        return [
            'tokens' => $tokens,
        ];
    }
}
