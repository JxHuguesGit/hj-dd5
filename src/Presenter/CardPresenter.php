<?php
namespace src\Presenter;

use src\Model\PageElement;

class CardPresenter
{
    /** @var PageElement[] */
    private array $elements = [];

    public function __construct(array $elements = [])
    {
        foreach ($elements as $el) {
            $this->addElement($el);
        }
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

        $html = '';

        foreach ($this->elements as $el) {
            $html .= sprintf(
                '<a href="%s" class="card">
                    <h3>%s</h3>
                    <p>%s</p>
                </a>',
                $el->getUrl(),
                htmlspecialchars($el->getTitle()),
                htmlspecialchars($el->getDescription())
            );
        }
/*
                    <i class="%s icon"></i>
                $el->getUrl(),
*/
        return $html;
    }

    /** Accès brut si besoin */
    public function getElements(): array
    {
        return $this->elements;
    }
}
