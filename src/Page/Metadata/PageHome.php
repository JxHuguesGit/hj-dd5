<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;

class PageHome extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => C::HOME,
            'icon'                    => I::HOUSE,
            C::TITLE       => L::HOME,
            C::DESCRIPTION => '',
            'url'                     => '/',
            'order'                   => 0,
            C::PARENT      => null,
        ];
    }
}
