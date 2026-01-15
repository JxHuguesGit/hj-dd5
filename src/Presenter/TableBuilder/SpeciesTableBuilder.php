<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Specie as DomainSpecie;
use src\Service\WpPostService;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class SpeciesTableBuilder implements TableBuilderInterface
{
    public function build(iterable $species, array $params = []): Table
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

        foreach ($species as $specie) {
            /** @var DomainSpecie $specie */
            $this->addSpecieRow($table, $specie);
        }
        return $table;
    }

    private function addHeaders(Table $table): void
    {
        $headerLabels = [
            Language::LG_SPECIE,
            Language::LG_CREATURE_TYPE,
            Language::LG_SIZE_CATEGORY,
            Language::LG_SPEED,
        ];
        foreach ($headerLabels as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }
    }

    private function addSpecieRow(Table $table, DomainSpecie $specie): void
    {
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
        $fields = [
            Constant::CST_CREATURE_TYPE,
            Constant::CST_SIZE_CATEGORY,
            Constant::CST_SPEED,
        ];
        [$strCreatureType, $strSizeCategory, $strSpeed] = array_map(fn($key) => $wpPostServices->getField($key) ?? '', $fields);

        $table->addBodyRow([])
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

}
