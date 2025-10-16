<?php
namespace src\Controller;

use src\Constant\Field;
use src\Entity\RpgJoinMonsterTypeSpeed as EntityRpgJoinMonsterTypeSpeed;
use src\Utils\Utils;

class RpgJoinMonsterTypeSpeed extends Utilities
{
    protected EntityRpgJoinMonsterTypeSpeed $rpgJoinMonsterTypeSpeed;

    public function getFormatString(): string
    {
        $str  = $this->rpgJoinMonsterTypeSpeed->getTypeSpeed()->getField(Field::NAME);
        $str .= ' ' . $this->rpgJoinMonsterTypeSpeed->getField(Field::VALUE) . 'm';
        $str .= ' ' . $this->rpgJoinMonsterTypeSpeed->getField(Field::EXTRA);
        return $str;
    }

}
