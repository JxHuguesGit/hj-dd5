<?php
namespace src\Action\Ajax;

use src\Constant\Constant as C;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Renderer\TemplateRenderer;
use src\Service\Ajax\CharacterCreationAjax;
use src\Utils\Session;

class LoadCreationStepSide implements AjaxActionInterface
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function execute(): mixed
    {
        $ajax = new CharacterCreationAjax($this->readerFactory, $this->serviceFactory, $this->renderer);
        return $ajax->loadCreationStepSide(
            Session::fromPost(C::TYPE),
            Session::fromPost(C::ID)
        );
    }
}
