<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Constant\Routes;

class PageGear extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::GEAR,
            'icon'                    => Icon::IBOXOPEN,
            Constant::CST_TITLE       => Language::LG_EQUIPMENT,
            Constant::CST_DESCRIPTION => 'Découvrez l\'équipement jouable.',
            'url'                     => Routes::ITEM_PREFIX,
            'order'                   => 50,
            Constant::CST_PARENT      => Constant::CST_ITEMS,
        ];
    }
}
