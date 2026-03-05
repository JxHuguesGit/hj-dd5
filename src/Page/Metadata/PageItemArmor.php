<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageItemArmor extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::SLUG        => Constant::ITEMS . '-' . Constant::ARMOR,
            'icon'                    => I::SHIELD,
            Constant::TITLE       => L::ARMORS_TITLE,
            Constant::DESCRIPTION => 'Les armures disponibles pour les aventuriers.',
            'url'                     => Routes::ITEMS_PREFIX . Constant::ARMOR,
            'order'                   => 5,
            Constant::PARENT      => Constant::ITEMS,
        ];
    }
}
