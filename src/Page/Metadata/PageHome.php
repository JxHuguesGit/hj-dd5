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
            Constant::SLUG        => Constant::HOME,
            'icon'                    => I::HOUSE,
            Constant::TITLE       => L::HOME,
            Constant::DESCRIPTION => '',
            'url'                     => '/',
            'order'                   => 0,
            Constant::PARENT      => null,
        ];
    }
}
