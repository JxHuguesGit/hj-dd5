<?php
namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Utils\Html;

abstract class AbstractDetailContentBuilder implements ContentBuilderInterface
{
    public function build(object $data, array $params = []): string
    {
        $content =
            $this->renderDetailHeader($data)
            . $this->renderDetailBody($data, $params)
            . $this->renderDetailNavigation($data)
        ;

        return Html::getBalise(
            H::BALISE_ARTICLE,
            $content,
            [C::CSSCLASS => B::DATA_DETAIL]
        );
    }

    protected function renderDetailHeader(object $view) : string
    {
        return $this->renderHeader($view->name);
    }

    abstract protected function renderDetailBody(object $view, array $params) : string;

    protected function renderDetailNavigation(object $view): string
    {
        return $this->renderNavigation(
            $view->previous
                ? $this->getDetailUrl($view->previous->slug)
                : null,
            $view->previous
                ? $view->previous->name
                : null,
            $view->next
                ? $this->getDetailUrl($view->next->slug)
                : null,
            $view->next
                ? $view->next->name
                : null
        );
    }

    abstract protected function getDetailUrl(string $slug): string;

    protected function renderHeader(
        string $title,
        string $subtitle = '',
        string $subtitleClass = ''
    ): string
    {
        $content = Html::getBalise(
            H::BALISE_H1,
            htmlspecialchars($title)
        );

        $headerClass = B::DATA_DETAIL_HEADER;

        if ($subtitle !== '') {
            $headerClass .= ' has-subtitle';
            
            $content .= Html::getBalise(
                H::BALISE_SPAN,
                $subtitle,
                [
                    C::CSSCLASS => $subtitleClass,
                ]
            );
        }

        return Html::getBalise(
            H::BALISE_HEADER,
            $content,
            [C::CSSCLASS =>$headerClass]
        );
    }

    protected function renderNavigation(
        ?string $previousUrl,
        ?string $previousLabel,
        ?string $nextUrl,
        ?string $nextLabel
    ): string {
        $content = '';
        $navigationClass = B::DATA_DETAIL_NAVIGATION;

        if ($previousUrl !== null) {
            $content .= Html::getLink(
                '&lt; ' . htmlspecialchars($previousLabel),
                $previousUrl,
                'btn btn-sm btn-outline-dark'
            );

            if ($nextUrl === null) {
                $navigationClass .= ' only-prev';
            }
        }

        if ($nextUrl !== null) {
            $content .= Html::getLink(
                htmlspecialchars($nextLabel) . ' &gt;',
                $nextUrl,
                'btn btn-sm btn-outline-dark'
            );

            if ($previousUrl === null) {
                $navigationClass .= ' only-next';
            }
        }

        if ($content === '') {
            return '';
        }

        return Html::getBalise(
            H::BALISE_NAV,
            $content,
            [
                C::CSSCLASS => $navigationClass,
            ]
        );
    }
}
