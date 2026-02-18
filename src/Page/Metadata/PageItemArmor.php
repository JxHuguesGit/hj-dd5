<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Constant\Routes;

class PageItemArmor extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::CST_ITEMS.'-'.Constant::CST_ARMOR,
            'icon'                    => Icon::ISHIELD,
            Constant::CST_TITLE       => Language::LG_ARMORS,
            Constant::CST_DESCRIPTION => 'Les armures disponibles pour les aventuriers.',
            'url'                     => Routes::ITEMS_PREFIX.Constant::CST_ARMOR,
            'order'                   => 5,
            Constant::CST_PARENT      => Constant::CST_ITEMS,
        ];
    }
}
