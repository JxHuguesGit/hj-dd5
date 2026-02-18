<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Constant\Routes;

class PageSpells extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::SPELLS,
            'icon'                    => Icon::ISPARKLES,
            Constant::CST_TITLE       => Language::LG_SPELLS,
            Constant::CST_DESCRIPTION => 'Les sorts auxquels ont accès les différentes classes.',
            'url'                     => Routes::SPELLS_PREFIX,
            'order'                   => 20,
            Constant::CST_PARENT      => Constant::HOME,
        ];
    }
}
