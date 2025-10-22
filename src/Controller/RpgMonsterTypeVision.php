<?php
namespace src\Controller;

use src\Constant\Field;
use src\Entity\RpgMonsterTypeVision as EntityRpgMonsterTypeVision;

class RpgMonsterTypeVision extends Utilities
{
    protected EntityRpgMonsterTypeVision $rpgMonsterTypeVision;

    public function getFormatString(): string
    {
        $str  = $this->rpgMonsterTypeVision->getTypeVision()->getField(Field::NAME);
        $str .= ' ' . $this->rpgMonsterTypeVision->getField(Field::VALUE) . 'm';
        $extra = $this->rpgMonsterTypeVision->getField(Field::EXTRA);
        if ($extra!='') {
            $str .= ' ' . $extra;
        }
        return $str;
    }

}
