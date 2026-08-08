<?php
namespace src\Action\Ajax;

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

    public function execute(): array
    {
        return [
            // TODO $mapId
            'tokens' => $this->serviceFactory
                ->mapToken()
                ->buildTokens(1),
        ];
    }
}
