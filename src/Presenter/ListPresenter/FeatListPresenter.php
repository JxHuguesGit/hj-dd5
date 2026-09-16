<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Domain\Criteria\FeatAbilityCriteria;
use src\Domain\Entity\Feat;
use src\Domain\Entity\FeatType;
use src\Domain\Entity\PreRequis;
use src\Presenter\ViewModel\FeatGroup;
use src\Presenter\ViewModel\FeatRow;
use src\Presenter\ViewModel\LinkView;
use src\Service\Domain\FeatPreRequisService;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\FeatAbilityReader;
use src\Service\Reader\FeatTypeReader;
use src\Service\Reader\OriginReader;
use src\Service\Reader\ReferenceReader;
use src\Utils\UrlGenerator;

final class FeatListPresenter
{
    public function __construct(
        private OriginReader $originReader,
        private FeatPreRequisService $featPrerequisiteService,
        private FeatTypeReader $featTypeReader,
        private ReferenceReader $sourceReader,
        private FeatAbilityReader $featAbilityReader,
        private AbilityReader $abilityReader,
    ) {}

    public function present(iterable $feats): Collection
    {
        $featTypes = [];
        foreach ($this->featTypeReader->allFeatTypes() as $featType) {
            $featTypes[$featType->id] = $featType;
        }

        $grouped = [];
        foreach ($feats as $feat) {
            /** @var Feat $feat */
            $grouped[$feat->featTypeId][] = $this->buildRow(
                $feat,
                $featTypes[$feat->featTypeId] ?? null
            );
        }

        $collection = new Collection();

        foreach ($grouped as $typeId => $rows) {
            /** @var ?FeatType $featType */
            $featType = $featTypes[$typeId] ?? null;

            $preRequis = $featType
                ? $this->featPrerequisiteService->preRequisForFeatType($featType)
                : null;

            $collection->add(new FeatGroup(
                label: $this->getTypeLabel($featType),
                slug: $featType ? '-' . $featType->slug : '',
                extraPrerequis: $preRequis?->name ?? '',
                rows: $rows
            ));
        }

        return $collection;
    }

    private function buildRow(Feat $feat, ?FeatType $featType): FeatRow
    {
        $preRequis = $this->featPrerequisiteService->preRequisForFeat($feat);
        $source = $this->sourceReader->referenceById($feat->sourceId);

        return new FeatRow(
            id: $feat->id,
            name: $feat->name,
            slug: $feat->slug,
            url: UrlGenerator::feat($feat->slug),
            sourceName: $source->name ?? $feat->sourceId,
            sourceId: $source->id ?? $feat->sourceId,
            origins: $this->buildOrigins($feat, $featType),
            abilities: $this->buildAbilities($feat),
            prerequisite: $this->formatPrerequisites($preRequis),
            preRequisId: $preRequis->id ?? 0,
        );
    }

    private function buildAbilities(Feat $feat): array
    {
        $criteria = new FeatAbilityCriteria();
        $criteria->featId = $feat->id;

        $featAbilities = $this->featAbilityReader->allFeatAbilities($criteria);
        if ($featAbilities->isEmpty()) {
            return [];
        }

        $result = [];
        foreach ($featAbilities as $fa) {
            $ability = $this->abilityReader->abilityById($fa->abilityId);
            if ($ability) {
                $result[] = new LinkView(
                    name: $ability->name,
                    slug: ''
                );
            }
        }

        return $result;
    }

    private function buildOrigins(Feat $feat, ?FeatType $featType): array
    {
        if ($featType?->slug !== C::ORIGIN) {
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

    private function formatPrerequisites(Collection|PreRequis|null $preRequis): ?string
    {
        if ($preRequis === null || $preRequis instanceof Collection && $preRequis->isEmpty()) {
            return null;
        }

        if ($preRequis instanceof PreRequis) {
            return $preRequis->name;
        }

        $names = [];

        foreach ($preRequis as $preRequisItem) {
            $names[] = $preRequisItem->name;
        }

        return implode(', ', $names);
    }

    private function getTypeLabel(?FeatType $featType): string
    {
        return match ($featType?->slug) {
            C::ORIGIN => L::ORIGIN_FEATS,
            C::GENERAL => L::GENERAL_FEATS,
            C::COMBAT => L::CBT_STYLE_FEATS,
            C::EPIC => L::CBT_STYLE_EPICS,
            default => $featType?->name ?? '',
        };
    }
}
