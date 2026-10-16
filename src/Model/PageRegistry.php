<?php
namespace src\Model;

use src\Page\Metadata\{
    PageItems,
    PageFeats,
    PageFeatsCombat,
    PageFeatsEpic,
    PageFeatsGeneral,
    PageFeatsOrigin,
    PageGlossaire,
    PageHome,
    PageHomebrew,
    PageMetadata,
    PageOrigines,
    PageRules,
    PageSkills,
    PageSpecies,
    PageSpells
};

class PageRegistry
{
    private static ?self $instance = null;

    /** @var PageElement[] */
    private array $pages = [];

    // Singleton.
    private function __construct()
    {
        $this->loadStaticPages();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadStaticPages(): void
    {
        $pages = [
            // Page Home
            new PageHome(),
            // Page Origines (liste)
            new PageOrigines(),
            // Page Espèces (liste)
            new PageSpecies(),
            // Page Dons (liste)
            new PageFeats(),
                // Catégories de Dons (liste)
                new PageFeatsCombat(),
                new PageFeatsEpic(),
                new PageFeatsGeneral(),
                new PageFeatsOrigin(),
            // Page Items (liste)
            new PageItems(),
            // Page Skills (liste)
            new PageSkills(),
            // Page Spells (liste)
            new PageSpells(),
            // Page Règles (lite)
            new PageRules(),
                // Page Glossaire (liste)
                new PageGlossaire(),
                // Page Homebrew (liste)
                new PageHomebrew(),
        ];

        foreach ($pages as $page) {
            $this->registerPage($page);
        }
    }

    private function registerPage(PageMetadata $page): void
    {
        $config = $page->getConfig();

        if (
            ($config['adminOnly'] ?? false)
            && !current_user_can('manage_options')
        ) {
            return;
        }

        $this->register($page->getPageElement());
    }

    public function register(PageElement $elements): void
    {
        if (is_array($elements)) {
            foreach ($elements as $el) {
                $this->pages[$el->getSlug()] = $el;
            }
        } else {
            $this->pages[$elements->getSlug()] = $elements;
        }
    }

    public function get(string $slug): ?PageElement
    {
        return $this->pages[$slug] ?? null;
    }

    public function all(): array
    {
        $pages = $this->pages;
        usort($pages, fn($a, $b) => $a->getOrder() <=> $b->getOrder());
        return $pages;
    }
}

