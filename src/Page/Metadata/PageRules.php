<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageRules extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::SLUG        => Constant::RULES,
            'icon'                    => I::BOOK,
            Constant::TITLE       => L::RULES,
            Constant::DESCRIPTION => 'Découvrez les règles du jeu.',
            'url'                     => Routes::RULES_PREFIX,
            'order'                   => 70,
            Constant::PARENT      => Constant::HOME,
        ];
    }
}
