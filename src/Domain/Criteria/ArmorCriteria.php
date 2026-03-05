<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class ArmorCriteria extends BaseCriteria
{
    public ?int $id = null;
    public string $type = Constant::CST_ARMOR;
    public ?string $name = null;
    public ?string $slug = null;
    public ?int $armorTypeId = null;
    public ?int $armorClass = null;
    public ?string $nameLt  = null;
    public ?string $nameGt  = null;

    public array $orderBy = [
        F::ARMORTYPID => Constant::CST_ASC,
        F::ARMORCLASS => Constant::CST_ASC,
        F::NAME       => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $qb): void
    {
        $filters = [];
        if ($this->id !== null) {
            $filters[F::ID] = $this->id;
        }
        if ($this->type !== null) {
            $filters[F::TYPE] = $this->type;
        }
        if ($this->name !== null) {
            $filters[F::NAME] = $this->name;
        }
        if ($this->slug !== null) {
            $filters[F::SLUG] = $this->slug;
        }
        if ($this->armorTypeId !== null) {
            $filters[F::ARMORTYPID] = $this->armorTypeId;
        }
        if ($this->armorClass !== null) {
            $filters[F::ARMORCLASS] = $this->armorClass;
        }
        $this->applyEquals($qb, $filters);
        $this->applyLt($qb, F::NAME, $this->nameLt);
        $this->applyGt($qb, F::NAME, $this->nameGt);
    }
}
