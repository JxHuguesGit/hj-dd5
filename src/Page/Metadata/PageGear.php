<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageGear extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => C::GEAR,
            'icon'                    => I::BOXOPEN,
            C::TITLE       => L::EQUIPMENT,
            C::DESCRIPTION => 'Découvrez l\'équipement jouable.',
            'url'                     => Routes::ITEM_PREFIX,
            'order'                   => 50,
            C::PARENT      => C::ITEMS,
        ];
    }
}
