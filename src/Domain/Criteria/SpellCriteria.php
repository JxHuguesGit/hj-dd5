<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Constant\Table as T;
use src\Domain\Criteria\Attributes\Compare;
use src\Domain\Criteria\Attributes\Equals;
use src\Query\QueryBuilder;

final class SpellCriteria extends BaseCriteria
{
    public const DEFAULT_PAGE_SIZE = 12;
    public const WPPOST_ALIAS = 'wp';

    #[Equals(field: F::ID, alias : 's')]
    public ?int $id = null;

    #[Equals(field: 'post_title', alias: self::WPPOST_ALIAS)]
    public ?string $name = null;

    #[Equals(field: 'post_name', alias: self::WPPOST_ALIAS)]
    public ?string $slug = null;

    #[Equals(field: F::WPPOSTID)]
    public ?int $wpPostId = null;

    #[Compare(field: F::LEVEL, operator: Compare::GTE, alias: 's')]
    public ?string $levelMin = null;

    #[Compare(field: F::LEVEL, operator: Compare::LTE, alias: 's')]
    public ?string $levelMax = null;

    #[Compare(field: F::SCHOOLID, operator: Compare::IN, alias: 's')]
    public ?array $schoolIds = null;

    #[Compare(field: F::SOURCEID, operator: Compare::IN, alias: 's')]
    public array $sourceIds = [];

    #[Compare(field: F::CLASSEID, operator: Compare::IN, alias: 'rsc')]
    public array $classeIds = [];

    #[Equals(field: F::RITUEL, alias: 's')]
    public ?bool $ritual = null;

    #[Equals(field: F::CONCENTRATION, alias: 's')]
    public ?bool $concentration = null;

    #[Compare(field: 'post_title', operator: Compare::LT, alias: self::WPPOST_ALIAS)]
    public ?string $nameLt = null;

    #[Compare(field: 'post_title', operator: Compare::GT, alias: self::WPPOST_ALIAS)]
    public ?string $nameGt = null;

    public array $orderBy = [
        self::WPPOST_ALIAS . '.post_title' => C::ASC
    ];

    public static function fromRequest(array $request): self
    {
        $criteria = new self();

        $criteria->levelMin = isset($request['levelMinFilter'])
            ? (int) $request['levelMinFilter']
            : null;

        $criteria->levelMax = isset($request['levelMaxFilter'])
            ? (int) $request['levelMaxFilter']
            : null;

        $criteria->schoolIds = array_map(
            'intval',
            $request['schoolFilter'] ?? []
        );

        $criteria->sourceIds = array_map(
            'intval',
            $request['sourceFilter'] ?? []
        );

        $criteria->classeIds = array_map(
            'intval',
            $request['classFilter'] ?? []
        );

        $criteria->ritual = isset($request['onlyRituel'])
            ? true
            : null;

        $criteria->concentration = isset($request['onlyConcentration'])
            ? true
            : null;

        return $criteria;
    }

    public function join(QueryBuilder $qb): void
    {
        if ($this->classeIds !== []) {
            $qb->joinTable(' INNER JOIN ' . T::SPELLCLASSE . ' AS rsc ON rsc.' . F::SPELLID . ' = s.' . F::ID)
                ->joinTable(' INNER JOIN ' . T::RPGCLASSE . ' AS rc ON rc.' . F::ID . ' = rsc.' . F::CLASSEID);
        }
    }
}
