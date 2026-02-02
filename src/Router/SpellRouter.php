<?php
namespace src\Router;

use src\Constant\Constant;
use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicSpell;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Page\PageSpell;
use src\Presenter\MenuPresenter;
use src\Presenter\Detail\SpellDetailPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\SpellService;
use src\Service\Page\SpellPageService;

class SpellRouter
{
    public function __construct(
        private ServiceFactory $serviceFactory
    ) {}
    
    public function match(string $path): ?PublicBase
    {
        // Pour enlever l'alerte Sonar sur le fait que factory n'est pas utilisée dans la méthode.
        unset($factory);

        ////////////////////////////////////////////////////////////
        // --- Gestion d'un sort individuel ---
        if (!preg_match(Routes::SPELL_PATTERN, $path, $matches)) {
            return null;
        }

        return new PublicSpell(
            $matches[1] ?? '',
            new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SPELLS),
            new PageSpell(new TemplateRenderer()),
            new SpellService(
                $this->serviceFactory->wordPress()
            ),
            new SpellPageService(
                new SpellService(
                    $this->serviceFactory->wordPress()
                ),
                new SpellDetailPresenter()
            ),
            new SpellDetailPresenter()
        );
    }
}
