<?php
namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageRules extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => C::RULES,
            'icon'                    => I::BOOK,
            C::TITLE       => L::RULES,
            C::DESCRIPTION => 'Découvrez les règles du jeu.',
            'url'                     => Routes::RULES_PREFIX,
            'order'                   => 70,
            C::PARENT      => C::HOME,
        ];
    }
}
