<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Constant\Routes;

class PageOrigines extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::ORIGINES,
            'icon'                    => Icon::IUSERS,
            Constant::CST_TITLE       => Language::LG_HISTORIQUES,
            Constant::CST_DESCRIPTION => "L'historique de votre personnage est un ensemble d'éléments disparates qui symbolisent le lieu et l'occupation de votre héros en herbe avant qu'il embrasse la carrière d'aventurier.",
            'url'                     => Routes::ORIGINS_PREFIX,
            'order'                   => 40,
            Constant::CST_PARENT      => Constant::HOME,
        ];
    }
}

