<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;

final class ItemCriteria
{
    public string $type = 'other';
    public ?string $name = null;
    public array $orderBy = [
        Field::NAME => Constant::CST_ASC,
    ];
}
