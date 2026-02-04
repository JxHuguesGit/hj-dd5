<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class ArmorCriteria extends AbstractCriteria implements CriteriaInterface
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

    public function apply(QueryBuilder $qb): void
    {
        $filters = [];
        if ($this->type !== null) {
            $filters[Field::TYPE] = $this->type;
        }
        if ($this->name !== null) {
            $filters[Field::NAME] = $this->name;
        }
        if ($this->armorTypeId !== null) {
            $filters[Field::ARMORTYPID] = $this->armorTypeId;
        }
        if ($this->armorClass !== null) {
            $filters[Field::ARMORCLASS] = $this->armorClass;
        }
        $this->applyEquals($qb, $filters);
    }
}
