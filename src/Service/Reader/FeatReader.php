<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\FeatCriteria;
use src\Domain\Entity\Feat;
use src\Repository\FeatRepositoryInterface;
use src\Utils\Navigation;

final class FeatReader
{
    public function __construct(
        private FeatRepositoryInterface $featRepository,
    ) {}

    /**
     * @return ?Feat
     */
    public function featById(int $id): ?Feat
    {
        $criteria = new FeatCriteria();
        $criteria->id = $id;
        return $this->featRepository
            ->findAllWithRelations($criteria)
            ?->first() ?? null;
    }

    /**
     * @return ?Feat
     */
    public function featBySlug(string $slug): ?Feat
    {
        $criteria = new FeatCriteria();
        $criteria->slug = $slug;
        return $this->featRepository
            ->findAllWithRelations($criteria)
            ?->first() ?? null;
    }

    /**
     * @return Collection<Feat>
     */
    public function featsByCategory(int $featTypeId): Collection
    {
        $criteria = new FeatCriteria();
        $criteria->featTypeId = $featTypeId;
        return $this->featRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<Feat>
     */
    public function allFeats(?FeatCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new FeatCriteria();
        }
        return $this->featRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<Feat>
     */
    public function allFeatsWithRelations(?FeatCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new FeatCriteria();
        }
        return $this->featRepository->findAllWithRelations($criteria);
    }

    /**
     * @return array{prev: ?Feat, next: ?Feat}
     */
    public function getPreviousAndNext(Feat $feat): array
    {
        return Navigation::getPrevNext(
            function (string $operand, string $order) use ($feat) {
                $criteria = new FeatCriteria();
                $criteria->featTypeId = $feat->featTypeId;
                $criteria->sourceId   = $feat->sourceId;
                if ($operand === '&lt;') {
                    $criteria->nameLt = $feat->name;
                } else {
                    $criteria->nameGt = $feat->name;
                }
                $criteria->orderBy = [FeatCriteria::WPPOST_ALIAS . '.post_title' => $order];
                return $this->featRepository->findAllWithRelations($criteria);
            }
        );
    }

    /**
     * @return Collection<Feat>
     */
    public function allPublishedFeatsWithRelations(?FeatCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new FeatCriteria();
        }
        return $this->featRepository->findAllWithRelations($criteria)
            ->filter(
                static fn (Feat $feat): bool => $feat->name !== ''
            );
    }
}
