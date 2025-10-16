<?php
namespace src\Controller;

use src\Constant\Field;
use src\Entity\RpgMonsterAbility as EntityRpgMonsterAbility;
use src\Utils\Utils;

class RpgMonsterAbility extends Utilities
{
    protected EntityRpgMonsterAbility $rpgMonsterAbility;

    public function getFormatString(): string
    {
        $strTitle = $this->rpgMonsterAbility->getField(Field::NAME);
        $strContent = $this->rpgMonsterAbility->getField(Field::DESCRIPTION);
        $strContent = Utils::formatBBCode($strContent);


        return sprintf('<p><strong><em>%s</em></strong>. %s</p>', $strTitle, $strContent);
    }
}
