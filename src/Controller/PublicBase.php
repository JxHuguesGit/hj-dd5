<?php
namespace src\Controller;

use src\Exception\TemplateInvalid;
use src\Model\PageElement;
use src\Presenter\BreadcrumbPresenter;

class PublicBase
{
    protected string $title = '';
    protected PageElement $pageElement;

    public function getRender(string $urlTemplate, array $args=[]): string
    {
        if (file_exists(PLUGIN_PATH.$urlTemplate)) {
            return vsprintf(file_get_contents(PLUGIN_PATH.$urlTemplate), $args);
        } else {
            throw new TemplateInvalid($urlTemplate);
        }
    }

    public function getContentHeader(): string
    { return ''; }

    public function getContentFooter(): string
    { return ' '; }

    public function getPageElement(): PageElement
    { return $this->pageElement; }
    
    public function getBreadcrumb(): string
    {
        $page = $this->getPageElement();

        $presenter = new BreadcrumbPresenter($page);
        return $presenter->render();
    }
}

