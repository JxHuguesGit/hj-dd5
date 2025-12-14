<?php
namespace src\Controller;

use src\Constant\Field;
use src\Entity\RpgMonsterSkill as EntityRpgMonsterSkill;

class RpgMonsterSkill extends Utilities
{
    protected EntityRpgMonsterSkill $rpgMonsterSkill;

    public function getFormatString(): string
    {
        $str  = $this->rpgMonsterSkill->getSkill()->getField(Field::NAME);
        $str .= ' +'.$this->rpgMonsterSkill->getField(Field::VALUE);
        return $str;
    }

}
