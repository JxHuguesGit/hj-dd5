<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Feat as DomainFeat;
use src\Presenter\ViewModel\FeatGroup;
use src\Presenter\ViewModel\FeatRow;
use src\Service\Reader\OriginReader;
use src\Service\WpPostService;
use src\Utils\Html;
use src\Utils\UrlGenerator;
use src\Constant\Bootstrap;

final class FeatListPresenter
{
    public function __construct(
        private OriginReader $originReader,
        private WpPostService $wpPostService
    ) {}

    public function present(Collection $feats): array
    {
        $grouped = [];
        foreach ($feats as $feat) {
            /** @var DomainFeat $feat */
            $grouped[$feat->featTypeId][] = $this->buildRow($feat);
        }

        $types = self::getFeatTypes();
        $result = [];
        foreach ($grouped as $typeId => $rows) {
            $result[] = new FeatGroup(
                label: $types[$typeId][Constant::CST_LABEL] ?? '',
                slug: $types[$typeId][Constant::CST_SLUG] ?? '',
                extraPrerequis: $types[$typeId][Constant::CST_EXTRA_PREREQUIS] ?? '',
                rows: $rows
            );
        }

        return [Constant::CST_ITEMS => $result];
    }

    private function buildRow(DomainFeat $feat): FeatRow
    {
        [$originLabel, $prerequisite] = $this->resolveFeatDetails($feat);

        return new FeatRow(
            name: $feat->name,
            url: UrlGenerator::feat($feat->slug),
            originLabel: $originLabel,
            prerequisite: $prerequisite
        );
    }

    private function resolveFeatDetails(DomainFeat $feat): array
    {
        switch ($feat->featTypeId) {
            case DomainFeat::TYPE_ORIGIN:
                $origins = $this->originReader->originsByFeat($feat);
                $parts = [];
                foreach ($origins as $origin) {
                    $parts[] = Html::getLink($origin->name, UrlGenerator::origin($origin->slug), Bootstrap::CSS_TEXT_DARK);
                }
                return [implode(', ', $parts), '-'];
            case DomainFeat::TYPE_GENERAL:
            case DomainFeat::TYPE_EPIC:
                $this->wpPostService->getById($feat->postId);
                $wpPreRequis = $this->wpPostService->getField(Constant::CST_PREREQUIS);
                return ['-', $wpPreRequis ? ucfirst($wpPreRequis) : '-'];
            default:
                return ['-', '-'];
        }
    }

    private static function getFeatTypes(): array
    {
        return [
            DomainFeat::TYPE_ORIGIN  => [
                Constant::CST_SLUG => Constant::ORIGIN,
                Constant::CST_LABEL => Language::LG_ORIGIN_FEATS,
                Constant::CST_EXTRA_PREREQUIS => ''
            ],
            DomainFeat::TYPE_GENERAL => [
                Constant::CST_SLUG => Constant::GENERAL,
                Constant::CST_LABEL => Language::LG_GENERAL_FEATS,
                Constant::CST_EXTRA_PREREQUIS => Constant::CST_PREREQUIS_NIV4.')'
            ],
            DomainFeat::TYPE_COMBAT  => [
                Constant::CST_SLUG => Constant::COMBAT,
                Constant::CST_LABEL => Language::LG_CBT_STYLE_FEATS,
                Constant::CST_EXTRA_PREREQUIS => Constant::CST_PREREQUIS_ASDC.')'
            ],
            DomainFeat::TYPE_EPIC    => [
                Constant::CST_SLUG => Constant::EPIC,
                Constant::CST_LABEL => Language::LG_CBT_STYLE_EPICS,
                Constant::CST_EXTRA_PREREQUIS => Constant::CST_PREREQUIS_NIV19.')'
            ],
        ];
    }
}
