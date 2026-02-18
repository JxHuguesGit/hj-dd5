<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;

class PageHome extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::HOME,
            'icon'                    => Icon::IHOUSE,
            Constant::CST_TITLE       => Language::LG_HOME,
            Constant::CST_DESCRIPTION => '',
            'url'                     => '/',
            'order'                   => 0,
            Constant::CST_PARENT      => null,
        ];
    }
}
