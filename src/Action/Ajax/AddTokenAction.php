<?php
namespace src\Action\Ajax;

use src\Constant\Field as F;
use src\Domain\Entity\MapToken;
use src\Domain\Entity\Token;
use src\Exception\MapNotFoundException;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory as WF;

final class AddTokenAction
{
    public function __construct(
        private WF $writerFactory,
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory
    ) {}

    public function execute(): array
    {
        $type = filter_input(INPUT_POST, 'tokenType');

        $token = new Token([
            F::NAME        => filter_input(INPUT_POST, 'tokenName'),
            F::IMAGE       => filter_input(INPUT_POST, 'tokenImage'),
            F::SIZE        => filter_input(INPUT_POST, 'tokenSize'),
            F::TYPE        => $type,
            F::CHARACTERID => null, // TODO à traiter
            F::MONSTERID   => $type == 'monster' ? filter_input(INPUT_POST, 'tokenMonsterId') : null,
            F::ACTIVE      => filter_input(INPUT_POST, 'active') ?? 0
        ]);

        $this->writerFactory->token()->insert($token);

        return ['status' => 'success'];
    }
}
