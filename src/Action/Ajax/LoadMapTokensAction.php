<?php
namespace src\Action\Ajax;

use src\Constant\Constant as C;
use src\Factory\ServiceFactory;

final class LoadMapTokensAction
{
    public function __construct(
        private ServiceFactory $serviceFactory,
    ) {}

    public function execute(array $params): array
    {
        return [
            'tokens' => $this->serviceFactory
                ->mapToken()
                ->buildTokens($params[C::MAPID]),
        ];
    }
}
