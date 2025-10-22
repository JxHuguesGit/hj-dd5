<?php
namespace src\Controller;

use src\Constant\Field;
use src\Entity\RpgMonsterTypeSpeed as EntityRpgMonsterTypeSpeed;

class RpgMonsterTypeSpeed extends Utilities
{
    protected EntityRpgMonsterTypeSpeed $rpgMonsterTypeSpeed;

    public function getFormatString(): string
    {
        $str  = $this->rpgMonsterTypeSpeed->getTypeSpeed()->getField(Field::NAME);
        $str .= ' ' . $this->rpgMonsterTypeSpeed->getField(Field::VALUE) . 'm';
        $str .= ' ' . $this->rpgMonsterTypeSpeed->getField(Field::EXTRA);
        return $str;
    }

}
