<?php
namespace src\Domain\Criteria\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Compare
{
    public const EQ   = '=';
    public const NEQ  = '!=';
    public const LT   = '<';
    public const LTE  = '<=';
    public const GT   = '>';
    public const GTE  = '>=';
    public const LIKE = 'LIKE';

    public function __construct(
        public string $field,
        public string $operator,
        public ?string $alias = null
    ) {
        $allowed = [
            self::EQ, self::NEQ, self::LT, self::LTE,
            self::GT, self::GTE, self::LIKE,
        ];

        if (!in_array($this->operator, $allowed, true)) {
            throw new \InvalidArgumentException(
                sprintf("Unsupported operator '%s' for Compare attribute", $this->operator)
            );
        }
    }
}
