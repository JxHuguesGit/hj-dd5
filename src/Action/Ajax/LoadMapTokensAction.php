<?php
namespace src\Action\Ajax;

use src\Constant\Constant as C;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Renderer\TemplateRenderer;

final class LoadMapTokensAction
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
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
