<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Domain\Criteria\Attributes\Compare;
use src\Domain\Criteria\Attributes\Equals;
use src\Query\QueryBuilder;

abstract class AbstractCriteria implements CriteriaInterface
{
    /** @var array<string,string> */
    public array $orderBy = [];

    /** @var int|null */
    public ?int $limit = -1;

    /** @var int|null */
    public ?int $offset = 0;

    public function apply(QueryBuilder $qb): void
    {
        // 1) Nouveau système : appliquer les attributs si présents
        $this->applyAttributes($qb);

        // 2) Ancien système : laisser les Criteria existants continuer à utiliser leur apply()
        if (method_exists($this, 'applyLegacy')) {
            $this->applyLegacy($qb);
        }

        // 3) APPLY COMMON (orderBy / limit / offset)
        if ($this->orderBy) {
            $qb->orderBy($this->orderBy);
        }
        if ($this->limit !== -1) {
            $qb->limit($this->limit, $this->offset ?? 0);
        }
    }

    private function applyAttribute(QueryBuilder $qb, mixed $attr, mixed $value): void
    {
        $instance = $attr->newInstance();

        $field = $instance->alias
            ? $instance->alias . '.' . $instance->field
            : $instance->field;

        // Equals
        if ($instance instanceof Equals) {
            $qb->where([$field => $value]);
            return;
        }

        // Compare
        if ($instance instanceof Compare) {
            $qb->whereComplex([[
                'field'   => $field,
                'operand' => $instance->operator,
                'value'   => $value,
            ]]);
        }
    }

    private function applyAttributes(QueryBuilder $qb): void
    {
        $values = get_object_vars($this);
        $ref = new \ReflectionObject($this);

        foreach ($ref->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            $name = $prop->getName();
            if (!array_key_exists($name, $values)) {
                continue;
            }

            $value = $values[$name];
            if ($value === null) {
                continue;
            }

            foreach ($prop->getAttributes() as $attr) {
                $this->applyAttribute($qb, $attr, $value);
            }
        }
    }

    protected function applyLegacy(QueryBuilder $qb): void
    {
        // par défaut : ne rien faire
    }

    protected function applyEquals(
        QueryBuilder $queryBuilder,
        array $filters
    ): void {
        if ($filters) {
            $queryBuilder->where($filters);
        }
    }

    protected function applyLt(
        QueryBuilder $queryBuilder,
        string $field,
        mixed $value
    ): void {
        if ($value !== null) {
            $queryBuilder->whereComplex([
                ['field' => $field, 'operand' => '<', C::VALUE => $value],
            ]);
        }
    }

    protected function applyGt(
        QueryBuilder $queryBuilder,
        string $field,
        mixed $value
    ): void {
        if ($value !== null) {
            $queryBuilder->whereComplex([
                ['field' => $field, 'operand' => '>', C::VALUE => $value],
            ]);
        }
    }

    protected function applyRange(
        QueryBuilder $qb,
        string $field,
        mixed $lt,
        mixed $gt
    ): void {
        $this->applyLt($qb, $field, $lt);
        $this->applyGt($qb, $field, $gt);
    }
}
