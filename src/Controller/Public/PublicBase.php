<?php
namespace src\Controller\Public;

use src\Exception\TemplateInvalid;
use src\Model\PageElement;

class PublicBase
{
    protected ?string $title = '';
    protected PageElement $pageElement;

    public function getRender(string $urlTemplate, array $args=[]): string
    {
        if (count($args)==2) {
            $args[] = '';
        }
        if (file_exists(PLUGIN_PATH.$urlTemplate)) {
            return vsprintf(file_get_contents(PLUGIN_PATH.$urlTemplate), $args);
        } else {
            throw new TemplateInvalid($urlTemplate);
        }
    }

    public function getTitle(): string
    {
        return $this->title ?? '';
    }

    public function getContentHeader(): string
    { return ''; }

    public function getContentPage(): string
    { return '  '; }

    public function getContentFooter(): string
    { return ' '; }

    public function getPageElement(): PageElement
    { return $this->pageElement; }

}

