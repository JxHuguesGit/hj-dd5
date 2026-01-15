<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Domain\Specie as DomainSpecie;
use src\Presenter\ViewModel\SpeciesRow;
use src\Service\WpPostService;
use src\Utils\UrlGenerator;

final class SpeciesListPresenter
{
    public function __construct(private WpPostService $wpPostService) {}

    public function present(Collection $species): array
    {
        $rows = [];
        foreach ($species as $specie) {
            $rows[] = $this->buildRow($specie);
        }

        return [Constant::CST_ITEMS => $rows];
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
