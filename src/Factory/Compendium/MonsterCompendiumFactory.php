<?php

namespace src\Factory\Compendium;

use src\Controller\Compendium\MonsterCompendiumHandler;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory;
use src\Presenter\ListPresenter\MonsterListPresenter;
use src\Presenter\Modal\MonsterFilterModalPresenter;
use src\Presenter\TableBuilder\MonsterTableBuilder;
use src\Presenter\ToastBuilder;
use src\Renderer\TemplateRenderer;
use src\Service\Formatter\MonsterFormatter;

class MonsterCompendiumFactory extends AbstractCompendiumFactory
{
    public function __construct(
        protected TemplateRenderer $renderer,
        protected ReaderFactory $readerFactory,
        protected WriterFactory $writerFactory,
        protected ServiceFactory $serviceFactory
    ) {}

    public function create(): MonsterCompendiumHandler
    {
        return new MonsterCompendiumHandler(
            $this->writerFactory->monster(),
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
