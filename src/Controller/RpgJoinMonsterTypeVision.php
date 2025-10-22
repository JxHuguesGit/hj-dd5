<?php
namespace src\Controller;

use src\Constant\Field;
use src\Entity\RpgJoinMonsterTypeVision as EntityRpgJoinMonsterTypeVision;
use src\Utils\Utils;

class RpgJoinMonsterTypeVision extends Utilities
{
    protected EntityRpgJoinMonsterTypeVision $rpgJoinMonsterTypeVision;

    public function getFormatString(): string
    {
        $str  = $this->rpgJoinMonsterTypeVision->getTypeVision()->getField(Field::NAME);
        $str .= ' ' . $this->rpgJoinMonsterTypeVision->getField(Field::VALUE) . 'm';
        $extra = $this->rpgJoinMonsterTypeVision->getField(Field::EXTRA);
        if ($extra!='') {
            $str .= ' ' . $extra;
        }
        return $str;
    }

}
