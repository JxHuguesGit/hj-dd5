<?php
namespace src\Action\Ajax;

use src\Constant\Constant as C;
use src\Factory\ServiceFactory;

final class ResetMapFogAction
{
    public function __construct(
        private ServiceFactory $serviceFactory
    ) {}

    public function execute(array $params): array
    {
        $this->serviceFactory
            ->mapFog()
            ->reset(
                $params[C::MAPID]
            );

        return [
            'status' => 'success'
        ];
    }
}