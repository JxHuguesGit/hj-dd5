<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Domain\Entity\Specie;
use src\Presenter\ViewModel\SpeciesGroup;
use src\Presenter\ViewModel\SpeciesRow;
use src\Service\Domain\WpPostService;
use src\Utils\UrlGenerator;

final class SpeciesListPresenter
{
    public function __construct(private WpPostService $wpPostService) {}

    public function present(iterable $species): Collection
    {
        $rows = [];

        foreach ($species as $specie) {
            $rows[] = $this->buildRow($specie);
        }

        $collection = new Collection();

        $collection->add(new SpeciesGroup(
            label: '',
            slug: 'species',
            rows: $rows
        ));

        return $collection;
    }

    private function buildRow(Specie $specie): SpeciesRow
    {
        $this->wpPostService->getById($specie->postId);

        return new SpeciesRow(
            name: $specie->name,
            url: UrlGenerator::specie($specie->getSlug()),
            creatureType: (string)$this->wpPostService->getField(C::CREATURE_TYPE),
            sizeCategory: (string)$this->wpPostService->getField(C::SIZE_CATEGORY),
            speed: (string)$this->wpPostService->getField(C::SPEED)
        );
    }
}
