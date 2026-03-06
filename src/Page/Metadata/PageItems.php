<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageItems extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => C::ITEMS,
            'icon'                    => I::SCROLL,
            C::TITLE       => L::GEAR_TITLE,
            C::DESCRIPTION => "Tout l'équipement dont a besoin un aventurier.",
            'url'                     => Routes::ITEMS_PREFIX,
            'order'                   => 50,
            C::PARENT      => C::HOME,
        ];
    }
}
