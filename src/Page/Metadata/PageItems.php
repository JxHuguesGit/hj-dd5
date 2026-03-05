<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageItems extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::SLUG        => Constant::ITEMS,
            'icon'                    => I::SCROLL,
            Constant::TITLE       => L::GEAR_TITLE,
            Constant::DESCRIPTION => "Tout l'équipement dont a besoin un aventurier.",
            'url'                     => Routes::ITEMS_PREFIX,
            'order'                   => 50,
            Constant::PARENT      => Constant::HOME,
        ];
    }
}
