<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;

final class ToolCriteria
{
    public string $type = Constant::CST_TOOL;
    public ?string $name = null;
    public array $orderBy = [
        Field::PARENTID => Constant::CST_ASC,
        Field::NAME     => Constant::CST_ASC,
    ];

}
