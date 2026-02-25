<?php
namespace src\Action\Ajax;

use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Renderer\TemplateRenderer;
use src\Service\Ajax\MonsterAjax;

class ModalMonsterCard
{
    public function __construct(
        private ReaderFactory $reader,
        private ServiceFactory $service,
        private TemplateRenderer $renderer
    ) {}

    public function execute(): mixed
    {
        $ajax = new MonsterAjax($this->reader, $this->service, $this->renderer);
        return $ajax->loadModal();
    }
}
