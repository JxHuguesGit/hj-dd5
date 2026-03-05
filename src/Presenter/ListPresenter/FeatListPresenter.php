<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Constant\Language as L;
use src\Domain\Entity\Feat;
use src\Presenter\ViewModel\FeatGroup;
use src\Presenter\ViewModel\FeatRow;
use src\Service\Domain\WpPostService;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\FeatAbilityReader;
use src\Service\Reader\OriginReader;
use src\Utils\Html;
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
                label: $types[$typeId][Constant::CST_LABEL] ?? '',
                slug: $types[$typeId][Constant::CST_SLUG] ?? '',
                extraPrerequis: $types[$typeId][Constant::CST_EXTRA_PREREQUIS] ?? '',
                rows: $rows
            ));
        }

        return $collection;
    }

    private function buildRow(Feat $feat): FeatRow
    {
        [$originLabel, $prerequisite] = $this->resolveFeatDetails($feat);

        return new FeatRow(
            name: $feat->name,
            slug: $feat->slug,
            url: UrlGenerator::feat($feat->slug),
            originLabel: $originLabel,
            prerequisite: $prerequisite
        );
    }

    private function resolveFeatDetails(Feat $feat): array
    {
        switch ($feat->featTypeId) {
            case Feat::TYPE_ORIGIN:
                $origins = $this->originReader->originsByFeat($feat);
                $parts   = [];
                foreach ($origins as $origin) {
                    $parts[] = Html::getLink($origin->name, UrlGenerator::origin($origin->slug), B::TEXT_DARK);
                }
                $returned = [implode(', ', $parts), '-'];
                break;
            case Feat::TYPE_GENERAL:
                $featAbilities = $this->featAbilityReader->featAbilitiesByFeatId($feat->id);
                $parts         = [];
                foreach ($featAbilities as $featAbility) {
                    $ability = $this->abilityReader->abilityById($featAbility->abilityId);
                    $parts[] = $ability->name;
                }

                $this->wpPostService->getById($feat->postId);
                $wpPreRequis = $this->wpPostService->getField(Constant::CST_PREREQUIS);
                $returned    = [implode(', ', $parts), $wpPreRequis ? ucfirst($wpPreRequis) : '-'];
                break;
            case Feat::TYPE_EPIC:
                $this->wpPostService->getById($feat->postId);
                $wpPreRequis = $this->wpPostService->getField(Constant::CST_PREREQUIS);
                $returned    = ['-', $wpPreRequis ? ucfirst($wpPreRequis) : '-'];
                break;
            default:
                $returned = ['-', '-'];
                break;
        }
        return $returned;
    }

    private static function getFeatTypes(): array
    {
        return [
            Feat::TYPE_ORIGIN  => [
                Constant::CST_SLUG            => '-' . Constant::ORIGIN,
                Constant::CST_LABEL           => L::ORIGIN_FEATS,
                Constant::CST_EXTRA_PREREQUIS => '',
            ],
            Feat::TYPE_GENERAL => [
                Constant::CST_SLUG            => '-' . Constant::GENERAL,
                Constant::CST_LABEL           => L::GENERAL_FEATS,
                Constant::CST_EXTRA_PREREQUIS => Constant::CST_PREREQUIS_NIV4 . ')',
            ],
            Feat::TYPE_COMBAT  => [
                Constant::CST_SLUG            => '-' . Constant::COMBAT,
                Constant::CST_LABEL           => L::CBT_STYLE_FEATS,
                Constant::CST_EXTRA_PREREQUIS => Constant::CST_PREREQUIS_ASDC . ')',
            ],
            Feat::TYPE_EPIC    => [
                Constant::CST_SLUG            => '-' . Constant::EPIC,
                Constant::CST_LABEL           => L::CBT_STYLE_EPICS,
                Constant::CST_EXTRA_PREREQUIS => Constant::CST_PREREQUIS_NIV19 . ')',
            ],
        ];
    }
}
