<?php
namespace src\Controller;

use src\Constant\Field;
use src\Entity\RpgMonsterLanguage as EntityRpgMonsterLanguage;

class RpgMonsterLanguage extends Utilities
{
    protected EntityRpgMonsterLanguage $rpgMonsterLanguage;

    public function getStrLanguage(): string
    {
        $objLanguage = $this->rpgMonsterLanguage->getLanguage();
        $str = $objLanguage->getField(Field::NAME);
        $value = $this->rpgMonsterLanguage->getField(Field::VALUE);
        if ($value!=0) {
            $str .= ' '.$value.'m';
        }
        return $str;
    }
}
