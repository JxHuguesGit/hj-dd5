<?php
namespace src\Presenter;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Model\PageElement;
use src\Utils\Html;

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

        $html = '';

        foreach ($this->elements as $el) {
            if ($el->getSlug() !== 'home' && $el->getParentSlug() !== 'home') {
                continue;
            }
            $activeClass = ($el->getSlug() === $this->currentSlug) ? ' '.Constant::CST_ACTIVE : '';
            $strSpan = Html::getSpan(htmlspecialchars($el->getTitle()), [Constant::CST_CLASS => Bootstrap::CSS_NAV_LINK_TITLE]);
            $strLink = Html::getLink($strSpan, trim($el->getUrl(), '-'), implode(' ', [Bootstrap::CSS_NAV_LINK, Bootstrap::CSS_TEXT_DARK]));
            $html .= Html::getLi($strLink, [Constant::CST_CLASS => Bootstrap::CSS_NAV_ITEM.$activeClass]);
        }

        $strUl = Html::getBalise('ul', $html, [Constant::CST_CLASS => 'navbar-nav']);
        $strDiv = Html::getDiv($strUl, [Constant::CST_CLASS => 'container-xl']);
        return Html::getBalise('nav', $strDiv, [Constant::CST_CLASS => 'navbar navbar-expand-md navbar-light pb-0']);
    }

    /**
     * Accès brut aux éléments (facultatif)
     */
    public function getElements(): array
    {
        return $this->elements;
    }
}
