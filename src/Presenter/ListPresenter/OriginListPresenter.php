<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Domain\Entity\Origin;
use src\Presenter\ViewModel\OriginGroup;
use src\Presenter\ViewModel\OriginRow;
use src\Service\Domain\OriginService;
use src\Utils\Html;
use src\Utils\UrlGenerator;
use src\Constant\Bootstrap;

final class OriginListPresenter
{
    public function __construct(private OriginService $originService) {}

    public function present(iterable $origins): Collection
    {
        $rows = [];
        foreach ($origins as $origin) {
            $rows[] = $this->buildRow($origin);
        }

        $collection = new Collection();
        $collection->add(new OriginGroup(label: 'Origines', slug: 'origins', rows: $rows));
        return $collection;
    }

    private function buildRow(Origin $origin): OriginRow
    {
        return new OriginRow(
            name: $origin->name??'',
            url: UrlGenerator::origin($origin->slug)??'',
            abilities: implode(', ', array_map(fn($a) => $a->name, $this->originService->getAbilities($origin)->toArray())),
            skills: implode(', ', array_map(fn($s) => Html::getLink($s->name, UrlGenerator::skill($s->slug), Bootstrap::CSS_TEXT_DARK), $this->originService->getSkills($origin)->toArray())),
            originFeat: $this->originFeatLink($origin),
            tool: $this->originToolLink($origin)
        );
    }

    private function originFeatLink(Origin $origin): string
    {
        $feat = $this->originService->getFeat($origin);
        return $feat ? Html::getLink($feat->name, UrlGenerator::feat($feat->getSlug()), Bootstrap::CSS_TEXT_DARK) : '-';
    }

    private function originToolLink(Origin $origin): string
    {
        $tool = $this->originService->getTool($origin);
        return $tool ? Html::getLink($tool->name, UrlGenerator::item($tool->getSlug()), Bootstrap::CSS_TEXT_DARK) : '-';
    }
}
