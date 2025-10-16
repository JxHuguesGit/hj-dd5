<?php
namespace src\Controller;

use src\Constant\Field;
use src\Entity\RpgMonsterResistance as EntityRpgMonsterResistance;
use src\Utils\Utils;

class RpgMonsterResistance extends Utilities
{
    protected EntityRpgMonsterResistance $rpgMonsterResistance;

    public function getFormatString(): string
    {
        return '';
    }

}
