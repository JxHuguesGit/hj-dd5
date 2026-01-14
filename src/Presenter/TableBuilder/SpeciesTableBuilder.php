<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Service\WpPostService;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class SpeciesTableBuilder implements TableBuilderInterface
{
    public function build(iterable $species, array $params = []): Table
    {
        $withMarginTop = $params[Bootstrap::CSS_WITH_MRGNTOP] ?? true;

        $objTable = new Table();
        $objTable->setTable([Constant::CST_CLASS => implode(' ', [
                Bootstrap::CSS_TABLE_SM,
                Bootstrap::CSS_TABLE_STRIPED,
                $withMarginTop ? Bootstrap::CSS_MT5 : ''
            ])])
            ->addHeader([Constant::CST_CLASS => implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_SPECIE])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_CREATURE_TYPE])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_SIZE_CATEGORY])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_SPEED]);

        foreach ($species as $specie) {
            /////////////////////////////////////////////////////////////////////
            // Le nom
            $strName = $specie->name;
            $strUrl = Html::getLink(
                $strName,
                UrlGenerator::specie($specie->getSlug()),
                Bootstrap::CSS_TEXT_DARK
            );
            
            /////////////////////////////////////////////////////////////////////
            // Les données rattachées au WpPost
            $wpPostServices = new WpPostService();
            $wpPostServices->getById($specie->postId);
            $strCreatureType = $wpPostServices->getField(Constant::CST_CREATURE_TYPE) ?? '';
            $strSizeCategory = $wpPostServices->getField(Constant::CST_SIZE_CATEGORY) ?? '';
            $strSpeed        = $wpPostServices->getField(Constant::CST_SPEED) ?? '';

            $objTable->addBodyRow([])
                ->addBodyCell([Constant::CST_CONTENT => $strUrl])
                ->addBodyCell([Constant::CST_CONTENT => $strCreatureType])
                ->addBodyCell([Constant::CST_CONTENT => $strSizeCategory])
                ->addBodyCell([
                    Constant::CST_CONTENT => $strSpeed,
                    Constant::CST_ATTRIBUTES => [
                        Constant::CST_CLASS => Bootstrap::CSS_TEXT_CENTER,
                    ],
                ]);
        }

        return $objTable;
    }

}
