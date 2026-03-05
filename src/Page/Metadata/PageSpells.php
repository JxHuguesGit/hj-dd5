<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageSpells extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::SPELLS,
            'icon'                    => I::SPARKLES,
            Constant::CST_TITLE       => L::SPELLS_TITLE,
            Constant::CST_DESCRIPTION => 'Les sorts auxquels ont accès les différentes classes.',
            'url'                     => Routes::SPELLS_PREFIX,
            'order'                   => 60,
            Constant::CST_PARENT      => Constant::HOME,
        ];
    }
}
