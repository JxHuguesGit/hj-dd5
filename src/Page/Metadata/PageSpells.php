<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageSpells extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => C::SPELLS,
            'icon'                    => I::SPARKLES,
            C::TITLE       => L::SPELLS_TITLE,
            C::DESCRIPTION => 'Les sorts auxquels ont accès les différentes classes.',
            'url'                     => Routes::SPELLS_PREFIX,
            'order'                   => 60,
            C::PARENT      => C::HOME,
        ];
    }
}
