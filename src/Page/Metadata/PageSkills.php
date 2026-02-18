<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Constant\Routes;

class PageSkills extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::CST_SLUG        => Constant::SKILLS,
            'icon'                    => Icon::ISTAR,
            Constant::CST_TITLE       => Language::LG_SKILLS,
            Constant::CST_DESCRIPTION => "Les compétences sont des aptitudes liées aux caractéristiques qui permettent d'accomplir certaines actions spécifiques.",
            'url'                     => Routes::SKILLS_PREFIX,
            'order'                   => 10,
            Constant::CST_PARENT      => Constant::HOME,
        ];
    }

}
