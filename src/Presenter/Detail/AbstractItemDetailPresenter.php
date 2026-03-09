<?php
namespace src\Presenter\Detail;

use src\Constant\Constant as C;
use src\Presenter\ViewModel\PageViewInterface;
use src\Utils\Utils;

abstract class AbstractItemDetailPresenter implements DetailPresenterInterface
{
    public function present(PageViewInterface $viewData): array
    {
        return [
            C::TITLE                   => $viewData->item->name,
            C::SLUG        => $viewData->item->slug,
            C::DESCRIPTION => $viewData->item->description,
            C::WEIGHT                  => Utils::getStrWeight($viewData->item->weight ?? 0),
            C::GOLDPRICE               => Utils::getStrPrice($viewData->item->goldPrice ?? 0),

            C::PREV        => $viewData->previous ? [
                C::SLUG => $viewData?->previous->slug,
                C::NAME => $viewData?->previous->name,
            ] : null,

            C::NEXT        => $viewData->next ? [
                C::SLUG => $viewData?->next->slug,
                C::NAME => $viewData?->next->name,
            ] : null,
        ];
    }
}
