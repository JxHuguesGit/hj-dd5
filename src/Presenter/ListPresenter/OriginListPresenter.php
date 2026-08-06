<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Domain\Entity\Origin;
use src\Presenter\ViewModel\OriginGroup;
use src\Presenter\ViewModel\OriginRow;
use src\Service\Domain\OriginService;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class OriginListPresenter
{
    public function __construct(private OriginService $originService)
    {}

    public function present(iterable $origins): Collection
    {
        $rows = [];
        foreach ($origins as $origin) {
            $rows[] = $this->buildRow($origin);
        }

        $collection = new Collection();
        $collection->add(new OriginGroup(label: '', slug: 'origins', rows: $rows));
        return $collection;
    }

    private function buildRow(Origin $origin): OriginRow
    {
        return new OriginRow(
            name: $origin->name,
            url: UrlGenerator::origin($origin->slug),
            abilities: $this->buildAbilities($origin),
            skills: $this->buildSkills($origin),
            originFeat: $this->originFeatLink($origin),
            tool: $this->originToolLink($origin)
        );
    }

    private function buildSkills(Origin $origin): string
    {
        return implode(
            ', ',
            array_map(
                fn($skill) => Html::getLink(
                    $skill->name,
                    UrlGenerator::skill($skill->slug),
                    B::TEXT_DARK
                ),
                $this->originService->getSkills($origin)->toArray()
            )
        );
    }

    private function buildAbilities(Origin $origin): string
    {
        return implode(
            ', ',
            array_map(
                fn($ability) => $ability->name,
                $this->originService->getAbilities($origin)->toArray()
            )
        );
    }

    private function originFeatLink(Origin $origin): string
    {
        $feat = $this->originService->getFeat($origin);
        return $feat ? Html::getLink($feat->name, UrlGenerator::feat($feat->getSlug()), B::TEXT_DARK) : '-';
    }

    private function originToolLink(Origin $origin): string
    {
        $tool = $this->originService->getTool($origin);
        return $tool ? Html::getLink($tool->name, UrlGenerator::item($tool->getSlug()), B::TEXT_DARK) : '-';
    }
}
