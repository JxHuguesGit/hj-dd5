<?php
namespace src\Router;

use src\Collection\Collection;
use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicHome;
use src\Controller\Public\PublicNotFound;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Page\PageNotFound;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Utils\Session;

class Router
{
    private Collection $handlers;

    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory
    ) {
        $this->handlers = new Collection([
            new OriginRouter($this->readerFactory, $this->serviceFactory),
            new SpecieRouter($this->readerFactory, $this->serviceFactory),
            new SpellRouter($this->serviceFactory),
            new FeatRouter($this->readerFactory, $this->serviceFactory),
            new ItemRouter($this->readerFactory, $this->serviceFactory),
            new RegistryRouter($this->readerFactory, $this->serviceFactory),
        ]);
    }

    public function fromHome(string $path): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion de la page d'accueil ---
        if ($path === '' || $path === 'home') {
            return new PublicHome();
        }

        return null;
    }

    private static function normalizePath(string $url): string
    {
        $path = trim(parse_url($url, PHP_URL_PATH), '/');

        // Gestion éventuelle du préfixe (DD5_URL)
        if (defined('DD5_URL')) {
            return $path;
        }

        $prefix = trim(parse_url(DD5_URL, PHP_URL_PATH), '/');
        if (str_starts_with($path, $prefix)) {
            $path = trim(substr($path, strlen($prefix)), '/');
        }
        return $path;
    }

    public function getController(): PublicBase
    {
        $path = $this->normalizePath(Session::getRequestUri());

        foreach ($this->handlers as $handler) {
            $controller = $handler->match($path);
            if ($controller !== null) {
                return $controller;
            }
        }

        return $this->fromHome($path)
            ?? new PublicNotFound(
                new PageNotFound(
                    new TemplateRenderer()
                ),
                new MenuPresenter(PageRegistry::getInstance()->all(), '')
            );
    }
}
