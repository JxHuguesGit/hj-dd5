<?php
namespace src\Model;

use src\Page\PageItems;
use src\Page\PageFeats;
use src\Page\PageFeatsCombat;
use src\Page\PageFeatsEpic;
use src\Page\PageFeatsGeneral;
use src\Page\PageFeatsOrigin;
use src\Page\PageHome;
use src\Page\PageOrigines;
use src\Page\PageSkills;
use src\Page\PageSpecies;

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
        // Page Home
        $homePage = (new PageHome())->getPageElement();
        $this->register($homePage);

        // Page Origines (liste)
        $originesPage = (new PageOrigines())->getPageElement();
        $this->register($originesPage);

        // Page Espèces (liste)
        $speciesPage = (new PageSpecies())->getPageElement();
        $this->register($speciesPage);

        // Page Dons (liste)
        $featsPage = (new PageFeats())->getPageElement();
        $this->register($featsPage);

        // Catégories de Dons (liste)
        $subFeatsPage = (new PageFeatsCombat())->getPageElement();
        $this->register($subFeatsPage);
        $subFeatsPage = (new PageFeatsEpic())->getPageElement();
        $this->register($subFeatsPage);
        $subFeatsPage = (new PageFeatsGeneral())->getPageElement();
        $this->register($subFeatsPage);
        $subFeatsPage = (new PageFeatsOrigin())->getPageElement();
        $this->register($subFeatsPage);

        // Page Items (liste)
        $itemsPage = (new PageItems())->getPageElement();
        $this->register($itemsPage);

        // Page Skills (liste)
        $skillsPage = (new PageSkills())->getPageElement();
        $this->register($skillsPage);

    }
    
    public function register($elements): void
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

