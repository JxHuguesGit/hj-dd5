<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageGear extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::SLUG        => Constant::GEAR,
            'icon'                    => I::BOXOPEN,
            Constant::TITLE       => L::EQUIPMENT,
            Constant::DESCRIPTION => 'Découvrez l\'équipement jouable.',
            'url'                     => Routes::ITEM_PREFIX,
            'order'                   => 50,
            Constant::PARENT      => Constant::ITEMS,
        ];
    }
}
