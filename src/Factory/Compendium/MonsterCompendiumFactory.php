<?php
namespace src\Factory\Compendium;

use src\Controller\Compendium\MonsterCompendiumHandler;
use src\Factory\ReaderFactory;
use src\Presenter\ListPresenter\MonsterListPresenter;
use src\Presenter\Modal\MonsterFilterModalPresenter;
use src\Presenter\TableBuilder\MonsterTableBuilder;
use src\Presenter\ToastBuilder;
use src\Service\Formatter\MonsterFormatter;

class MonsterCompendiumFactory extends AbstractCompendiumFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
    ) {}

    public function create(): MonsterCompendiumHandler
    {
        return new MonsterCompendiumHandler(
            $this->readerFactory->monster(),
            new MonsterListPresenter(
                new MonsterFormatter(
                    $this->readerFactory
                ),
            ),
            $this->page(new MonsterTableBuilder()),
            new MonsterFilterModalPresenter($this->renderer),
            new ToastBuilder($this->renderer),
            $this->renderer,
            $this->readerFactory
        );
    }
}
