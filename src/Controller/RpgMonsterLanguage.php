<?php
namespace src\Controller;

use src\Constant\Field;
use src\Entity\RpgJoinMonsterLanguage as EntityRpgJoinMonsterLanguage;

class RpgMonsterLanguage extends Utilities
{
    protected EntityRpgJoinMonsterLanguage $rpgJoinMonsterLanguage;

    public function __construct()
    {
        parent::__construct();
    }
    
    public function getStrLanguage(): string
    {
        $objLanguage = $this->rpgJoinMonsterLanguage->getLanguage();
        $str = $objLanguage->getField(Field::NAME);
        $value = $this->rpgJoinMonsterLanguage->getField(Field::VALUE);
        if ($value!=0) {
            $str .= ' '.$value.'m';
        }
        return $str;
    }
}
