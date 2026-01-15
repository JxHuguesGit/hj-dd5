<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Feat as DomainFeat;
use src\Presenter\ViewModel\FeatGroup;
use src\Service\Reader\OriginReader;
use src\Service\WpPostService;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class FeatTableBuilder implements TableBuilderInterface
{
    public function __construct(
        private OriginReader $originReader
    ) {}

    public function build(iterable $feats, array $params=[]): Table
    {
        $withMarginTop = $params[Bootstrap::CSS_WITH_MRGNTOP] ?? true;
    
        $table = new Table();
        $table->setTable([Constant::CST_CLASS => implode(' ', [
                Bootstrap::CSS_TABLE_SM,
                Bootstrap::CSS_TABLE_STRIPED,
                $withMarginTop ? Bootstrap::CSS_MT5 : ''
            ])])
            ->addHeader([Constant::CST_CLASS => implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow();
        $this->addHeaders($table);

        foreach ($feats as $group) {
            $this->addGroupRow($table, $group);

            foreach ($group->feats as $feat) {
                /** @var DomainFeat $feat */
                $this->addFeatRow($table, $feat);
            }
        }

        return $table;
    }

    private function addHeaders(Table $table): void
    {
        $headerLabels = [
            Language::LG_FEATS,
            Language::LG_ORIGIN,
            Language::LG_PREQUISITE,
        ];
        foreach ($headerLabels as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }
    }

    private function addGroupRow(Table $table, FeatGroup $featGroup): void
    {
        $strLink = Html::getLink(
            $featGroup->label,
            UrlGenerator::feats($featGroup->slug),
            Bootstrap::CSS_TEXT_WHITE
        ) . $featGroup->extraprerequis;

        $table->addBodyRow([Constant::CST_CLASS => Bootstrap::CSS_ROW_DARK_STRIPED])
            ->addBodyCell([
                Constant::CST_CONTENT => $strLink,
                Constant::CST_ATTRIBUTES => [
                    Constant::CST_COLSPAN => 6,
                    Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC
                ]
            ]);
    }

    private function addFeatRow(Table $table, DomainFeat $feat): void
    {
        $strLink = Html::getLink(
            $feat->name,
            UrlGenerator::feat($feat->slug),
            Bootstrap::CSS_TEXT_DARK
        );

        [$strOrigineLink, $strPreRequis] = $this->getFeatDetails($feat);

        /** @var DomainFeat $feat */
        $table->addBodyRow([])
            ->addBodyCell([Constant::CST_CONTENT => $strLink])
            ->addBodyCell([Constant::CST_CONTENT => $strOrigineLink])
            ->addBodyCell([Constant::CST_CONTENT => $strPreRequis])
            ;
    }

    private function getFeatDetails(DomainFeat $feat): array
    {
        switch ($feat->featTypeId) {
            case DomainFeat::TYPE_ORIGIN:
                $parts = [];
                $origins = $this->originReader->originsByFeat($feat);
                foreach ($origins as $origin) {
                    $parts[] = Html::getLink(
                        $origin->name,
                        UrlGenerator::origin($origin->slug),
                        Bootstrap::CSS_TEXT_DARK );
                }
                return [implode(', ', $parts), '-'];
            case DomainFeat::TYPE_GENERAL:
            case DomainFeat::TYPE_EPIC:
                $wpPostService = new WpPostService();
                $wpPostService->getById($feat->postId);
                $wpPreRequis = $wpPostService->getField(Constant::CST_PREREQUIS);
                return ['-', $wpPreRequis ? ucfirst($wpPreRequis) : '-'];
            default:
                return ['-', '-'];
        }
    }

}

