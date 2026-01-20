<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Domain\Specie as DomainSpecie;
use src\Presenter\ViewModel\SpeciesRow;
use src\Service\Domain\WpPostService;
use src\Utils\UrlGenerator;

final class SpeciesListPresenter
{
    public function __construct(private WpPostService $wpPostService) {}

    public function present(iterable $species): Collection
    {
        $collection = new Collection();
        foreach ($species as $specie) {
            $collection->addItem($this->buildRow($specie));
        }
        return $collection;
    }

    private function buildRow(DomainSpecie $specie): SpeciesRow
    {
        $this->wpPostService->getById($specie->postId);

        return new SpeciesRow(
            name: $specie->name,
            url: UrlGenerator::specie($specie->getSlug()),
            creatureType: (string)$this->wpPostService->getField(Constant::CST_CREATURE_TYPE),
            sizeCategory: (string)$this->wpPostService->getField(Constant::CST_SIZE_CATEGORY),
            speed: (string)$this->wpPostService->getField(Constant::CST_SPEED)
        );
    }
}
