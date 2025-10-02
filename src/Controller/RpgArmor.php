<?php
namespace src\Controller;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Entity\RpgArmor as EntityRpgArmor;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgArmor as RepositoryRpgArmor;
use src\Utils\Table;
use src\Utils\Utils;

class RpgArmor extends Utilities
{
    protected EntityRpgArmor $rpgArmor;

    public function __construct()
    {
        parent::__construct();

        $this->title = Language::LG_ARMORS;
    }

    public function getContentPage(): string
    {
        return 'WIP RpgArmor::getContentPage';
    }
    
    public static function getTable(): Table
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgArmor($queryBuilder, $queryExecutor);
        $rpgArmors = $objDao->findAll();

        $objTable = new Table();
        $objTable->setTable([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_SM, Bootstrap::CSS_TABLE_STRIPED, Bootstrap::CSS_MT5])])
            ->addHeader([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_ARMORS])
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_CA])
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_FORCE])
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_STEALTH])
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_WEIGHT])
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_PRICE]);

        if ($rpgArmors->valid()) {
            $objTable->addBodyRows($rpgArmors);
        }

        return $objTable; 
    }

    public function addBodyRow(Table &$objTable, array $arrParams, int &$oldTypeArmorId): void
    {
        // Classe d'armure
        $strClasseDArmure = $this->rpgArmor->getField(Field::ARMORCLASS);
        $typeArmorId = $this->rpgArmor->getField(Field::ARMORTYPID);
        switch ($typeArmorId) {
            case '4' :
                $strClasseDArmure = '+'.$strClasseDArmure;
            break;
            case '3' :
            break;
            case '2' :
                $strClasseDArmure .= Language::LG_MOD_DEX_MAX2;
            break;
            case '1' :
            default  :
                $strClasseDArmure .= Language::LG_MOD_DEX;
            break;
        }

        // Malus de Force
        if ($this->rpgArmor->getField(Field::MALUSSTR)==0) {
            $strMalusStrength = '-';
        } else {
            $strMalusStrength = Language::LG_FORCE_SHORT.' '.$this->rpgArmor->getField(Field::MALUSSTR);
        }

        // Malus Discrétion
        if ($this->rpgArmor->getField(Field::MALUSSTE)==0) {
            $strMalusDiscretion = '-';
        } else {
            $strMalusDiscretion = Language::LG_DISADVANTAGE;
        }

        if ($oldTypeArmorId!=$typeArmorId) {
            switch ($typeArmorId) {
                case 1 :
                    $libelle = Language::LG_ARM_LGT_DONDOFF;
                break;
                case 2 :
                    $libelle = Language::LG_ARM_MDM_DONDOFF;
                break;
                case 3 :
                    $libelle = Language::LG_ARM_HVY_DONDOFF;
                break;
                default :
                    $libelle = Language::LG_ARM_SHD_DONDOFF;
                break;
            }
            $objTable->addBodyRow()
                ->addBodyCell([Constant::CST_CONTENT=>$libelle, 'attributes'=>[Constant::CST_COLSPAN=>6, Constant::CST_CLASS=>Bootstrap::CSS_FONT_ITALIC]]);
        }

        $objTable->addBodyRow()
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgArmor->getField(Field::NAME)])
            ->addBodyCell([Constant::CST_CONTENT=>$strClasseDArmure])
            ->addBodyCell([Constant::CST_CONTENT=>$strMalusStrength])
            ->addBodyCell([Constant::CST_CONTENT=>$strMalusDiscretion])
            ->addBodyCell([Constant::CST_CONTENT=>Utils::getStrWeight($this->rpgArmor->getField(Field::WEIGHT)), 'attributes'=>[Constant::CST_CLASS=>Bootstrap::CSS_TEXT_END]])
            ->addBodyCell([Constant::CST_CONTENT=>Utils::getStrPrice($this->rpgArmor->getField(Field::GOLDPRICE)), 'attributes'=>[Constant::CST_CLASS=>Bootstrap::CSS_TEXT_END]]);

        $oldTypeArmorId = $typeArmorId;
    }
}