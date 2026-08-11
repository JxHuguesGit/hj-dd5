<?php
namespace src\Controller;


use src\Constant\Template as T;
use src\Controller\Admin\AdminNav;
use src\Factory\Admin\AdminContentFactory;
use src\Factory\Admin\AdminSidebarFactory;
use src\Renderer\TemplateRenderer;


final class AdminPage extends Utilities
{
    public function __construct(
        private array $arrUri,
        private AdminSidebarFactory $sidebarFactory,
        private AdminContentFactory $contentFactory,
    ) {
        parent::__construct($this->arrUri);
    }

    public function getAdminContentPage(): string
    {
        $renderer = new TemplateRenderer();
        $nav = new AdminNav();

        $content = $this->contentFactory
            ->create($this->arrParams)
            ->getContent();

        $sidebar = $this->sidebarFactory->create(
            $this->arrParams,
            fn(string $template, array $attributes): string =>
                $renderer->render($template, $attributes)
        );

        $attributes = [
            'Hugues Joneaux',
            $sidebar->getContent(),
            $content,
            PLUGINS_DD5,
            $nav->getContent()
        ];

        return $renderer->render(
            T::ADMINBASE,
            $attributes
        );
    }
}
