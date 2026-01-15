<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Weapon as DomainWeapon;
use src\Presenter\ViewModel\WeaponGroup;
use src\Service\WpPostService;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

class WeaponTableBuilder implements TableBuilderInterface
{
    public function build(iterable $groups, array $params=[]): Table
    {
        $withMarginTop = $params[Bootstrap::CSS_WITH_MRGNTOP] ?? true;
    
        $table = new Table();
        $table->setTable([Constant::CST_CLASS => implode(' ', [
                Bootstrap::CSS_TABLE_SM,
                Bootstrap::CSS_TABLE_STRIPED,
                $withMarginTop ? Bootstrap::CSS_MT5 : ''
            ])])
            ->addHeader([Constant::CST_CLASS => Bootstrap::CSS_TABLE_DARK])
            ->addHeaderRow();
        $this->addHeaders($table);

        foreach ($groups as $group) {
            $this->addGroupRow($table, $group);

            foreach ($group->weapons as $weapon) {
                /** @var DomainWeapon $weapon */
                $this->addWeaponRow($table, $weapon);
            }
        }

        return $table;

    }

    private function addHeaders(Table $table): void
    {
        $headerLabels = [
            Language::LG_WEAPONS,
            Language::LG_DAMAGES,
            Language::LG_PROPERTIES,
            Language::LG_WEAPON_PROP,
            Language::LG_WEIGHT,
            Language::LG_PRICE,
        ];
        foreach ($headerLabels as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }
    }

    private function addGroupRow(Table $table, WeaponGroup $weaponGroup): void
    {
        // Ligne de séparation
        $table->addBodyRow([Constant::CST_CLASS => Bootstrap::CSS_ROW_DARK_STRIPED])
            ->addBodyCell([
                Constant::CST_CONTENT => $weaponGroup->label,
                Constant::CST_ATTRIBUTES => [
                    Constant::CST_COLSPAN => 6,
                    Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC
                ]
            ]);
    }

    private function addWeaponRow(Table $table, DomainWeapon $weapon): void
    {
        $wpPostServices = new WpPostService();

        // Lien vers le détail de l'arme
        $strLink = Html::getLink(
            $weapon->name,
            UrlGenerator::item($weapon->getSlug()),
            Bootstrap::CSS_TEXT_DARK
        );

        // Dégâts
        $strDegats = $weapon->getDamageDie();

        // Propriétés
        /*
        $props = [];
        foreach ($weapon->getWeaponProficiencies() as $prop) {
            $props[] = $prop->getStrName();
        }
        $strProps = $props ? implode(', ', $props) : '-';
        */
        $strProps = 'TODO';

        // Botte
        $wpPostServices->getById($weapon->masteryPostId);
        $linkContent = $weapon->masteryName
            . Html::getSpan($wpPostServices?->getPostContent() ?? '', [Constant::CST_CLASS=>'tooltip-text']);
        $strMasteryUrl = Html::getLink(
            $linkContent,
            '#',
            Bootstrap::CSS_TEXT_DARK.' tooltip-trigger',
        );

        $table->addBodyRow([])
            ->addBodyCell([Constant::CST_CONTENT => $strLink])
            ->addBodyCell([Constant::CST_CONTENT => $strDegats])
            ->addBodyCell([Constant::CST_CONTENT => $strProps])
            ->addBodyCell([Constant::CST_CONTENT => $strMasteryUrl])
            ->addBodyCell([
                Constant::CST_CONTENT => Utils::getStrWeight($weapon->weight),
                Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]
            ])
            ->addBodyCell([
                Constant::CST_CONTENT => Utils::getStrPrice($weapon->goldPrice),
                Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]
            ]);
    }

}
