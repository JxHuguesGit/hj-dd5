<?php
namespace src\Presenter\Detail;

use src\Constant\Constant;
use src\Presenter\ViewModel\PageViewInterface;
use src\Utils\Utils;

abstract class AbstractItemDetailPresenter implements DetailPresenterInterface
{
    public function present(PageViewInterface $viewData): array
    {
        return [
            'title'                   => $viewData->item->name,
            Constant::SLUG        => $viewData->item->slug,
            Constant::DESCRIPTION => $viewData->item->description,
            'weight'                  => Utils::getStrWeight($viewData->item->weight ?? 0),
            'goldPrice'               => Utils::getStrPrice($viewData->item->goldPrice ?? 0),

            Constant::PREV        => $viewData->previous ? [
                Constant::SLUG => $viewData?->previous->slug,
                Constant::NAME => $viewData?->previous->name,
            ] : null,

            Constant::NEXT        => $viewData->next ? [
                Constant::SLUG => $viewData?->next->slug,
                Constant::NAME => $viewData?->next->name,
            ] : null,
        ];
    }
}
