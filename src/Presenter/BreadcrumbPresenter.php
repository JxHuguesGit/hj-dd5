<?php
namespace src\Presenter;

use src\Model\PageElement;
use src\Model\PageRegistry;

class BreadcrumbPresenter
{
    private PageElement $currentPage;

    public function __construct(PageElement $page)
    {
        $this->currentPage = $page;
    }

    public function render(): string
    {
        $registry = PageRegistry::getInstance();
        $crumbs = [];

        $page = $this->currentPage;

        // On remonte toute la chaîne
        while ($page !== null) {
            // ajoute au début
            array_unshift($crumbs, $page);
            $parentSlug = $page->getParentSlug();
            $page = $parentSlug ? $registry->get($parentSlug) : null;
        }

        // Ajouter la Home si elle n’est pas explicitement dans la chaîne
        if ($crumbs[0]->getSlug() !== 'home') {
            $home = $registry->get('home');
            if ($home) {
                array_unshift($crumbs, $home);
            }
        }

        // Génération HTML
        $html = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';

        $lastIndex = count($crumbs) - 1;

        foreach ($crumbs as $i => $el) {
            if ($i === $lastIndex) {
                $html .= '<li class="breadcrumb-item active" aria-current="page">'
                    . htmlspecialchars($el->getTitle())
                    . '</li>';
            } else {
                $html .= '<li class="breadcrumb-item"><a href="'
                    . htmlspecialchars($el->getUrl())
                    . '">'
                    . htmlspecialchars($el->getTitle())
                    . '</a></li>';
            }
        }

        $html .= '</ol></nav>';

        return $html;
    }
}
