<?php
namespace src\Router;

use src\Constant\Constant;
use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicSpell;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Page\PageSpell;
use src\Presenter\MenuPresenter;
use src\Presenter\Detail\SpellDetailPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\SpellService;
use src\Service\Domain\WpPostService;
use src\Service\Page\SpellPageService;

class SpellRouter
{
    public function match(string $path, ReaderFactory $factory, ServiceFactory $serviceFactory): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'un sort individuel ---
        if (!preg_match('#^spell-(.+)$#', $path, $matches)) {
            return null;
        }

        return new PublicSpell(
            $matches[1] ?? '',
            new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SPELLS),
            new PageSpell(new TemplateRenderer()),
            new SpellService(
                new WpPostService()
            ),
            new SpellPageService(
                new SpellService(
                    new WpPostService()
                ),
                new SpellDetailPresenter(
                    $serviceFactory->wordPress()
                )
            ),
            new SpellDetailPresenter(
                $serviceFactory->wordPress()
            )
        );
    }
}
