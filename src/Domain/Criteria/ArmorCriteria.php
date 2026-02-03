<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;

final class ArmorCriteria
{
    public string $type = Constant::CST_ARMOR;
    public ?string $name = null;
    public ?int $armorTypeId = null;
    public ?int $armorClass = null;

    public array $orderBy = [
        Field::ARMORTYPID => Constant::CST_ASC,
        Field::ARMORCLASS => Constant::CST_ASC,
        Field::NAME       => Constant::CST_ASC,
    ];
}
