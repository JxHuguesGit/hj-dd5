<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
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
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_FEATS])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_ORIGIN])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_PREQUISITE])
            ;

        foreach ($feats as $group) {
            if (count($feats)!=1) {
                $strLink = Html::getLink(
                    $group[Constant::CST_TYPELABEL],
                    UrlGenerator::feats($group[Constant::CST_SLUG]),
                    Bootstrap::CSS_TEXT_WHITE
                );

                if ($group[Constant::CST_SLUG]=='general') {
                    $strLink .= Constant::CST_PREREQUIS_NIV4.')';
                } elseif ($group[Constant::CST_SLUG]=='combat') {
                    $strLink .= Constant::CST_PREREQUIS_ASDC.')';
                } elseif ($group[Constant::CST_SLUG]=='epic') {
                    $strLink .= Constant::CST_PREREQUIS_NIV19.')';
                }
                // Ligne de rupture
                $table->addBodyRow([Constant::CST_CLASS => Bootstrap::CSS_ROW_DARK_STRIPED])
                    ->addBodyCell([
                        Constant::CST_CONTENT => $strLink,
                        Constant::CST_ATTRIBUTES => [
                            Constant::CST_COLSPAN => 6,
                            Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC
                        ]
                    ]);
            }

            foreach ($group[Constant::FEATS] as $feat) {
                $strLink = Html::getLink(
                    $feat->name,
                    UrlGenerator::feat($feat->slug),
                    Bootstrap::CSS_TEXT_DARK
                );

                switch ($feat->featTypeId) {
                    case 1 :
                        $parts = [];
                        $origins = $this->originReader->getOriginsByFeat($feat);
                        foreach ($origins as $origin) {
                            $parts[] = Html::getLink(
                                $origin->name,
                                UrlGenerator::origin($origin->slug),
                                Bootstrap::CSS_TEXT_DARK
                            );
                        }
                        $strOrigineLink = implode(', ', $parts);
                        $strPreRequis = '-';
                    break;
                    case 2:
                    case 4:
                        $strOrigineLink = '-';
                        $wpPostService = new WpPostService();
                        $wpPostService->getById($feat->postId);
                        $wpPreRequis = $wpPostService->getField(Constant::CST_PREREQUIS);
                        $strPreRequis = $wpPreRequis ? ucfirst($wpPreRequis) : '-';
                    break;
                    default :
                        $strOrigineLink = '-';
                        $strPreRequis = '-';
                    break;
                }

                /** @var DomainFeat $feat */
                $table->addBodyRow([])
                    ->addBodyCell([Constant::CST_CONTENT => $strLink])
                    ->addBodyCell([Constant::CST_CONTENT => $strOrigineLink])
                    ->addBodyCell([Constant::CST_CONTENT => $strPreRequis])
                    ;
            }
        }

        return $table;
    }
}
