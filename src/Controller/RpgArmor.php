<?php
namespace src\Controller;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\RpgArmor as DomainRpgArmor;
use src\Utils\Table;
use src\Utils\Utils;

class RpgArmor extends Utilities
{
    public function __construct()
    {
        parent::__construct();
        $this->title = Language::LG_ARMORS;
    }

    public function getContentPage(): string
    {
        return 'WIP RpgArmor::getContentPage';
    }
}
