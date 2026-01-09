<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Feat as DomainFeat;
use src\Repository\Feat as RepositoryFeat;

final class FeatReader
{
    public function __construct(
        private RepositoryFeat $featRepository,
    ) {}

    public function getFeat(int $id): ?DomainFeat
    {
        return $this->featRepository->find($id);
    }

    public function getAllFeats(array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        return $this->featRepository->findAll($order);
    }

    public function getFeatBySlug(string $slug): ?DomainFeat
    {
        $feat = $this->featRepository->findBy([Field::SLUG=>$slug]);
        return $feat?->first() ?? null;
    }

    public function getFeatsByCategory(int $categoryId, array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        return $this->featRepository->findBy([Field::FEATTYPEID=>$categoryId], $order);
    }

    public function getPreviousAndNext(DomainFeat $feat): array
    {
        // Don précédent (ordre alphabétique)
        $prev = $this->featRepository->findByComplex(
            [
                [
                    'field'   => Field::NAME,
                    'operand' => '<',
                    'value'   => $feat->name,
                ],
                [
                    'field'   => Field::FEATTYPEID,
                    'operand' => '=',
                    'value'   => $feat->featTypeId,
                ],
            ],
            [Field::NAME => Constant::CST_DESC],
            1
        )->first();

        // Don suivant
        $next = $this->featRepository->findByComplex(
            [
                [
                    'field'   => Field::NAME,
                    'operand' => '>',
                    'value'   => $feat->name,
                ],
                [
                    'field'   => Field::FEATTYPEID,
                    'operand' => '=',
                    'value'   => $feat->featTypeId,
                ],
            ],
            [Field::NAME => Constant::CST_ASC],
            1
        )->first();

        return [
            'prev' => $prev ?: null,
            'next' => $next ?: null,
        ];
    }
}
