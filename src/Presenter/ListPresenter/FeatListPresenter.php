<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Domain\Entity\Feat;
use src\Presenter\ViewModel\FeatGroup;
use src\Presenter\ViewModel\FeatRow;
use src\Presenter\ViewModel\LinkView;
use src\Service\Domain\WpPostService;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\FeatAbilityReader;
use src\Service\Reader\OriginReader;
use src\Utils\UrlGenerator;

final class FeatListPresenter
{
    public function __construct(
        private OriginReader $originReader,
        private FeatAbilityReader $featAbilityReader,
        private AbilityReader $abilityReader,
        private WpPostService $wpPostService
    ) {}

    public function present(iterable $feats): Collection
    {
        $grouped = [];
        foreach ($feats as $feat) {
            /** @var Feat $feat */
            $grouped[$feat->featTypeId][] = $this->buildRow($feat);
        }

        $types      = self::getFeatTypes();
        $collection = new Collection();
        foreach ($grouped as $typeId => $rows) {
            $collection->add(new FeatGroup(
                label: $types[$typeId][C::LABEL] ?? '',
                slug: $types[$typeId][C::SLUG] ?? '',
                extraPrerequis: $types[$typeId][C::EXTRA_PREREQUIS] ?? '',
                rows: $rows
            ));
        }

        return $collection;
    }

    private function buildRow(Feat $feat): FeatRow
    {
        return new FeatRow(
            name: $feat->name,
            slug: $feat->slug,
            url: UrlGenerator::feat($feat->slug),
            origins: $this->buildOrigins($feat),
            prerequisite: $this->resolveFeatPrerequisite($feat)
        );
    }

    private function buildOrigins(Feat $feat): array
    {
        if ($feat->featTypeId !== Feat::TYPE_ORIGIN) {
            return [];
        }
        
        $result = [];

        foreach ($this->originReader->originsByFeat($feat) as $origin) {
            $result[] = new LinkView(
                name: $origin->name,
                slug: $origin->slug
            );
        }

        return $result;
    }

    private function resolveFeatPrerequisite(Feat $feat): ?string
    {
        switch ($feat->featTypeId) {
            case Feat::TYPE_GENERAL:
            case Feat::TYPE_EPIC:
                $this->wpPostService->getById($feat->postId);
                $wpPreRequis = $this->wpPostService->getField(C::PREREQUIS);
                return $wpPreRequis ? ucfirst($wpPreRequis) : null;
            default:
                return null;
        }
    }

    private static function getFeatTypes(): array
    {
        return [
            Feat::TYPE_ORIGIN  => [
                C::SLUG            => '-' . C::ORIGIN,
                C::LABEL           => L::ORIGIN_FEATS,
                C::EXTRA_PREREQUIS => '',
            ],
            Feat::TYPE_GENERAL => [
                C::SLUG            => '-' . C::GENERAL,
                C::LABEL           => L::GENERAL_FEATS,
                C::EXTRA_PREREQUIS => C::PREREQUIS_NIV4 . ')',
            ],
            Feat::TYPE_COMBAT  => [
                C::SLUG            => '-' . C::COMBAT,
                C::LABEL           => L::CBT_STYLE_FEATS,
                C::EXTRA_PREREQUIS => C::PREREQUIS_ASDC . ')',
            ],
            Feat::TYPE_EPIC    => [
                C::SLUG            => '-' . C::EPIC,
                C::LABEL           => L::CBT_STYLE_EPICS,
                C::EXTRA_PREREQUIS => C::PREREQUIS_NIV19 . ')',
            ],
        ];
    }
}
