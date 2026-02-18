<?php
namespace src\Factory\Controller;

use src\Constant\Constant;
use src\Controller\Public\PublicOrigine;
use src\Factory\{ReaderFactory, ServiceFactory};
use src\Model\PageRegistry;
use src\Page\PageOrigine;
use src\Presenter\Detail\OriginDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Page\OriginPageService;

class OriginControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createDetailController(string $slug): PublicOrigine
    {
        return new PublicOrigine(
            $slug,
            $this->readerFactory->origin(),
            new OriginPageService(
                $this->serviceFactory->origin(),
                $this->readerFactory->origin()
            ),
            new OriginDetailPresenter(
                $this->serviceFactory->wordPress()
            ),
            new PageOrigine($this->renderer),
            new MenuPresenter(PageRegistry::getInstance()->all(), Constant::ORIGINES)
        );
    }
}
