<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Feat as DomainFeat;
use src\Domain\Origin as DomainOrigin;
use src\Exception\NotFoundException;
use src\Repository\Origin as RepositoryOrigin;

final class OriginReader
{
    public function __construct(
        private RepositoryOrigin $originRepository,
    ) {}

    public function getOrigin(int $id): ?DomainOrigin
    {
        return $this->originRepository->find($id);
    }

    public function getAllOrigins(array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        return $this->originRepository->findAll($order);
    }

    public function getOriginBySlug(string $slug): ?DomainOrigin
    {
        $origin = $this->originRepository->findBy([Field::SLUG=>$slug]);
        return $origin?->first() ?? null;
    }

    public function getOriginsByFeat(DomainFeat $feat): Collection
    {
        return $this->originRepository->findBy([Field::FEATID=>$feat->id]);
    }

    public function getOriginBySlugOrFail(string $slug): ?DomainOrigin
    {
        $origin = $this->getOriginBySlug($slug);
        if (!$origin) {
            throw new NotFoundException("Historique introuvable : $slug");
        }
        return $origin;
    }

    public function getPreviousAndNext(DomainOrigin $origin): array
    {
        // Origine précédente (ordre alphabétique)
        $prev = $this->originRepository->findByComplex(
            [
                [
                    'field'   => Field::NAME,
                    'operand' => '<',
                    'value'   => $origin->name,
                ]
            ],
            [Field::NAME => Constant::CST_DESC],
            1
        )->first();

        // Origine suivante
        $next = $this->originRepository->findByComplex(
            [
                [
                    'field'   => Field::NAME,
                    'operand' => '>',
                    'value'   => $origin->name,
                ]
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
