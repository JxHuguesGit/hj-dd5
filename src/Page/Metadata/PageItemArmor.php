<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageItemArmor extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => C::ITEMS . '-' . C::ARMOR,
            'icon'                    => I::SHIELD,
            C::TITLE       => L::ARMORS_TITLE,
            C::DESCRIPTION => 'Les armures disponibles pour les aventuriers.',
            'url'                     => Routes::ITEMS_PREFIX . C::ARMOR,
            'order'                   => 5,
            C::PARENT      => C::ITEMS,
        ];
    }
}
