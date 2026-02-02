<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Domain\Item as DomainItem;
use src\Presenter\ViewModel\GearRow;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

final class GearListPresenter
{
    public function present(iterable $gears): Collection
    {
        $collection = new Collection();
        foreach ($gears as $gear) {
            $collection->add($this->buildRow($gear));
        }
        return $collection;
    }

    private function buildRow(DomainItem $gear): GearRow
    {
        return new GearRow(
            name: $gear->name,
            url: UrlGenerator::item($gear->slug),
            weight: Utils::getStrWeight($gear->weight),
            price: Utils::getStrPrice($gear->goldPrice)
        );
    }
}
