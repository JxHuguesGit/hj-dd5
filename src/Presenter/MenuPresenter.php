<?php
namespace src\Presenter;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Model\PageElement;
use src\Utils\Html;

class MenuPresenter
{
    /** @var PageElement[] */
    private array $elements     = [];
    private string $currentSlug = '';

    public function __construct(array $elements = [], string $currentSlug = 'home')
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

        $html = '';

        foreach ($this->elements as $el) {
            if ($el->getSlug() !== 'home' && $el->getParentSlug() !== 'home') {
                continue;
            }
            $activeClass  = ($el->getSlug() === $this->currentSlug) ? ' ' . C::ACTIVE : '';
            $strLink      = Html::getLink(
                htmlspecialchars($el->getTitle()),
                trim($el->getUrl(), '-'),
                implode(' ', [B::NAV_LINK, B::TEXT_DARK, B::NAV_LINK_TITLE])
            );
            $html        .= Html::getLi($strLink, [C::CSSCLASS => B::NAV_ITEM . $activeClass]);
        }

        $strUl  = Html::getBalise('ul', $html, [C::CSSCLASS => 'nav-list']);
        return Html::getBalise('nav', $strUl, [C::CSSCLASS => 'main-nav', C::ID => 'mainMenu']);
    }

    /**
     * Accès brut aux éléments (facultatif)
     */
    public function getElements(): array
    {
        return $this->elements;
    }
}
