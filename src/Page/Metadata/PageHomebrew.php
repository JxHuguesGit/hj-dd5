<?php

namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageHomebrew extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => 'homebrew',
            'icon'         => I::BOOK,
            C::TITLE       => L::HOMEBREW_TITLE,
            C::DESCRIPTION => 'Liste des règles maison.',
            'url'          => Routes::RULES_PREFIX . Routes::HOMEBREW_PREFIX,
            'order'        => 72,
            C::PARENT      => C::RULES,
            'adminOnly'    => true,
        ];
    }
}
