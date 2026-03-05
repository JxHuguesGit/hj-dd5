<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language as L;

class PageHome extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::HOME,
            'icon'                    => I::HOUSE,
            Constant::CST_TITLE       => L::HOME,
            Constant::CST_DESCRIPTION => '',
            'url'                     => '/',
            'order'                   => 0,
            Constant::CST_PARENT      => null,
        ];
    }
}
