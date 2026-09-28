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

//    #[Compare(field: F::CLASSEID, operator: Compare::IN, alias: 'rsc')]
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
        ///////////////////////////////////
        // Critère sur les niveaux
        $criteria->levelMin = isset($request['levelMinFilter'])
            ? (int) $request['levelMinFilter']
            : null;

        $criteria->levelMax = isset($request['levelMaxFilter'])
            ? (int) $request['levelMaxFilter']
            : null;
        ///////////////////////////////////

        ///////////////////////////////////
        // Critère sur les écoles.
        $allSchools = (int) $request['selectAllSchool'];
        if ($allSchools!=1) {
            $criteria->schoolIds = array_map(
                'intval',
                $request['schoolFilter'] ?? []
            );
        }
        ///////////////////////////////////

        ///////////////////////////////////
        // Critère sur les sources.
        $allSources = (int) $request['selectAllSource'];
        if ($allSources!=1) {
            $criteria->sourceIds = array_map(
                'intval',
                $request['sourceFilter'] ?? []
            );
        }
        ///////////////////////////////////

        ///////////////////////////////////
        // Critère sur les classes.
        $allClasses = (int) $request['selectAllClass'];
        if ($allClasses!=1) {
            $criteria->classeIds = array_map(
                'intval',
                $request['classFilter'] ?? []
            );
        }
        ///////////////////////////////////

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
            $placeholders = implode(
                ', ',
                array_fill(0, count($this->classeIds), '%s')
            );

            $qb->whereRaw(
                'EXISTS (
                    SELECT 1
                    FROM ' . T::SPELLCLASSE . ' AS rsc
                    WHERE rsc.' . F::SPELLID . ' = s.' . F::ID . '
                    AND rsc.' . F::CLASSEID . ' IN (' . $placeholders . ')
                )',
                $this->classeIds
            );
        }
    }
}
