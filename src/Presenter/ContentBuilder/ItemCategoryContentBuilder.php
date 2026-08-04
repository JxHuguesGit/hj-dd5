<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Presenter\ViewModel\ItemCategory;
use src\Utils\Html;

final class ItemCategoryContentBuilder implements ContentBuilderInterface
{
    public function build(object $view, array $params = []): string
    {
        $content = '';

        foreach ($view as $category) {
            /** @var ItemCategory $category */

            $content .= Html::getLink(
                Html::getBalise(
                    H::BALISE_H2,
                    $category->title
                ),
                $category->url,
                B::CARD
            );
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::ITEM_CATEGORY_GRID]
        );
    }
}
