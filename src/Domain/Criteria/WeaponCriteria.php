<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;

final class WeaponCriteria
{
    public string $type = Constant::CST_WEAPON;
    public ?string $name = null;

    public array $orderBy = [
        Field::WPNCATID   => Constant::CST_ASC,
        Field::WPNRANGEID => Constant::CST_ASC,
        Field::NAME       => Constant::CST_ASC,
    ];

}
