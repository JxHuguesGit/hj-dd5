<?php
namespace src\Page\Metadata;

use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageSkills extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            Constant::SLUG        => Constant::SKILLS,
            'icon'                    => I::STAR,
            Constant::TITLE       => L::SKILLS_TITLE,
            Constant::DESCRIPTION => "Les compétences sont des aptitudes liées aux caractéristiques qui permettent d'accomplir certaines actions spécifiques.",
            'url'                     => Routes::SKILLS_PREFIX,
            'order'                   => 10,
            Constant::PARENT      => Constant::HOME,
        ];
    }

}
