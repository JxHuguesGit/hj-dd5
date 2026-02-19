<?php
namespace src\Controller\Compendium;

use src\Constant\Constant;
use src\Constant\Field;
use src\Page\PageList;
use src\Presenter\ListPresenter\OriginListPresenter;
use src\Service\Reader\OriginReader;

class OriginCompendiumHandler implements CompendiumHandlerInterface
{
    public function __construct(
        private OriginReader $reader,
        private OriginListPresenter $presenter,
        private PageList $page
    ) {}

    public function render(): string
    {
        $origins = $this->reader->allOrigins();
        $presentContent = $this->presenter->present($origins);
        return $this->page->renderAdmin('', $presentContent);
    }
}
