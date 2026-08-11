<?php
namespace src\Factory\Admin;

use src\Controller\Admin\AdminSidebar;
use src\Factory\ReaderFactory;
use src\Presenter\MenuPresenter\CharacterMenuPresenter;
use src\Presenter\MenuPresenter\CompendiumMenuPresenter;
use src\Presenter\MenuPresenter\MapMenuPresenter;
use src\Presenter\MenuPresenter\TimelineMenuPresenter;

final class AdminSidebarFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
    ) {}

    public function create(
        array $params,
        \Closure $renderer,
    ): AdminSidebar {
        return new AdminSidebar(
            new CharacterMenuPresenter(
                $this->readerFactory->character()
            ),
            new TimelineMenuPresenter(),
            new MapMenuPresenter(),
            new CompendiumMenuPresenter(),
            $renderer,
            $params
        );
    }
}
