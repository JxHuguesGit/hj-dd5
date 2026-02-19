<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Constant\Routes;

class PageItems extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::CST_ITEMS,
            'icon'                    => Icon::ISCROLL,
            Constant::CST_TITLE       => Language::LG_GEAR_TITLE,
            Constant::CST_DESCRIPTION => "Tout l'équipement dont a besoin un aventurier.",
            'url'                     => Routes::ITEMS_PREFIX,
            'order'                   => 50,
            Constant::CST_PARENT      => Constant::HOME,
        ];
    }
}
