<?php

namespace src\Page\Metadata;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Routes;

class PageGlossaire extends PageMetadata
{
    public function getConfig(): array
    {
        return [
            C::SLUG        => C::GLOSSARY,
            'icon'         => I::BOOK,
            C::TITLE       => L::GLOSSARY_TITLE,
            C::DESCRIPTION => 'Glossaire des termes de DD5.',
            'url'          => Routes::RULES_PREFIX . Routes::GLOSSARY_PREFIX,
            'order'        => 71,
            C::PARENT      => C::RULES,
            'adminOnly'    => true,
        ];
    }
}
