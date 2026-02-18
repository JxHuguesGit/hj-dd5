<?php
namespace src\Page\Metadata;

use src\Model\PageElement;

abstract class PageMetadata
{
    abstract protected function getConfig(): array;

    public function getPageElement(): PageElement
    {
        return new PageElement($this->getConfig());
    }
}
