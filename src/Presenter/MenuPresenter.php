<?php
namespace src\Presenter;

use src\Model\PageElement;

class MenuPresenter
{
    /** @var PageElement[] */
    private array $elements = [];
    private string $currentSlug = '';

    public function __construct(array $elements = [], string $currentSlug='home')
    {
        foreach ($elements as $el) {
            $this->addElement($el);
        }
        $this->currentSlug = $currentSlug;
    }

    public function addElement(PageElement $element): void
    {
        $this->elements[] = $element;
    }

    /**
     * @param PageElement[] $elements
     */
    public function render(): string
    {
        // Tri par "order"
        usort($this->elements, fn(PageElement $a, PageElement $b) => $a->getOrder() <=> $b->getOrder());

        $html = '<nav class="navbar navbar-expand-md navbar-light pb-0"><div class="container-xl"><ul class="navbar-nav">';

        foreach ($this->elements as $el) {
            if ($el->getSlug() !== 'home' && $el->getParentSlug() !== 'home') {
                continue;
            }
            
            $activeClass = ($el->getSlug() === $this->currentSlug) ? ' active' : '';
            
            $html .= sprintf(
                '<li class="nav-item%s">
                    <a class="nav-link text-dark" href="%s">
                        %s
                        <span class="nav-link-title">%s</span>
                    </a>
                </li>',
                $activeClass,
                $el->getUrl(),
                //$el->getIcon() ? '<i class="' . $el->getIcon() . '"></i>' : '',
                '',
                htmlspecialchars($el->getTitle())
            );
        }

        return $html.'</ul></div></nav>';
    }

    /**
     * Accès brut aux éléments (facultatif)
     */
    public function getElements(): array
    {
        return $this->elements;
    }
}
