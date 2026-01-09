<?php
namespace src\Service;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\RpgOrigin as DomainRpgOrigin;
use src\Exception\NotFoundException;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;

final class RpgOriginQueryService
{
    public function __construct(
        private RepositoryRpgOrigin $originRepository,
    ) {}

    public function getOrigin(int $id): ?DomainRpgOrigin
    {
        return $this->originRepository->find($id);
    }

    public function getAllOrigins(array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        return $this->originRepository->findAll($order);
    }

    public function getOriginBySlug(string $slug): ?DomainRpgOrigin
    {
        $origin = $this->originRepository->findBy([Field::SLUG=>$slug]);
        return $origin?->first() ?? null;
    }

    public function getOriginBySlugOrFail(string $slug): ?DomainRpgOrigin
    {
        $origin = $this->getOriginBySlug($slug);
        if (!$origin) {
            throw new NotFoundException("Historique introuvable : $slug");
        }
        return $origin;
    }

    public function getPreviousAndNext(DomainRpgOrigin $origin): array
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
