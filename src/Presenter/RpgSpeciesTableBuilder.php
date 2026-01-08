<?php
namespace src\Presenter;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Utils\Html;
use src\Utils\Table;

class RpgSpeciesTableBuilder
{
    public function build(iterable $species, array $params = []): Table
    {
        $objTable = new Table();
        $objTable->setTable([Constant::CST_CLASS => implode(' ', [Bootstrap::CSS_TABLE_SM, Bootstrap::CSS_TABLE_STRIPED, $params['withMarginTop'] ? Bootstrap::CSS_MT5 : ''])])
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
            $strUrl = Html::getLink($strName, '/specie-'.$specie->getSlug(), Bootstrap::CSS_TEXT_DARK);
            
            /////////////////////////////////////////////////////////////////////
            // Les données rattachées au WpPost
            $wpPost = get_post($specie->postId);
            $strCreatureType = get_field('type_de_creature', $wpPost->ID) ?? '';
            $strSizeCategory = get_field('categorie_de_taille', $wpPost->ID) ?? '';
            $strSpeed = get_field('vitesse', $wpPost->ID) ?? '';

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
