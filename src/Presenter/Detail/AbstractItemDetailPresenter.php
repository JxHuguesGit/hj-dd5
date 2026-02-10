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
            'title'       => $viewData->item->name,
            'slug'        => $viewData->item->getSlug(),
            'description' => $viewData->item->description,
            'weight'      => Utils::getStrWeight($viewData->item->weight),
            'goldPrice'   => Utils::getStrPrice($viewData->item->goldPrice),

            Constant::CST_PREV => $viewData->previous ? [
                Constant::CST_SLUG => $viewData?->previous->getSlug(),
                Constant::CST_NAME => $viewData?->previous->name,
            ] : null,

            Constant::CST_NEXT => $viewData->next ? [
                Constant::CST_SLUG => $viewData?->next->getSlug(),
                Constant::CST_NAME => $viewData?->next->name,
            ] : null,
        ];
    }
}
