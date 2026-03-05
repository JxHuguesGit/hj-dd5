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
            Constant::SLUG        => Constant::SPELLS,
            'icon'                    => I::SPARKLES,
            Constant::TITLE       => L::SPELLS_TITLE,
            Constant::DESCRIPTION => 'Les sorts auxquels ont accès les différentes classes.',
            'url'                     => Routes::SPELLS_PREFIX,
            'order'                   => 60,
            Constant::PARENT      => Constant::HOME,
        ];
    }
}
