<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language;
use src\Constant\Routes;

class PageRules extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::RULES,
            'icon'                    => I::BOOK,
            Constant::CST_TITLE       => Language::LG_RULES,
            Constant::CST_DESCRIPTION => 'Découvrez les règles du jeu.',
            'url'                     => Routes::RULES_PREFIX,
            'order'                   => 70,
            Constant::CST_PARENT      => Constant::HOME,
        ];
    }
}
