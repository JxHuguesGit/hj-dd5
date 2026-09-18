<?php
namespace src\Factory\Compendium;

use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory;
use src\Page\PageList;
use src\Renderer\TemplateRenderer;

abstract class AbstractCompendiumFactory
{
    public function __construct(
        protected TemplateRenderer $renderer,
        protected ReaderFactory $readerFactory,
        protected WriterFactory $writerFactory,
        protected ServiceFactory $serviceFactory,
    ) {}

    protected function page(object $tableBuilder): PageList
    {
        return new PageList($this->renderer, $tableBuilder);
    }
}
