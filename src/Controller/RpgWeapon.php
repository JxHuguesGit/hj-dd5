<?php
namespace src\Controller;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Entity\RpgWeapon as EntityRpgWeapon;
use src\Repository\RpgWeapon as RepositoryRpgWeapon;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Utils\Table;
use src\Utils\Utils;

class RpgWeapon extends Utilities
{
    protected EntityRpgWeapon $rpgWeapon;

    public function __construct()
    {
        parent::__construct();

        $this->title = Language::LG_WEAPONS;
    }

    public function getContentPage(): string
    {
        return 'WIP RpgWeapon::getContentPage';
    }
    
    public static function getTable(array $params): Table
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgWeapon($queryBuilder, $queryExecutor);
        $rpgWeapons = $objDao->findAll([Field::MARTIAL=>Constant::CST_ASC, Field::MELEE=>'DESC', Field::NAME=>Constant::CST_ASC]);
        $paginate = [
            Constant::PAGE_OBJS      => $rpgWeapons,
            Constant::CST_CURPAGE    => $params[Constant::CST_CURPAGE] ?? 1,
            Constant::PAGE_NBPERPAGE => $params[Constant::PAGE_NBPERPAGE] ?? 20
        ];

        $objTable = new Table();
        $objTable->setTable([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_SM, Bootstrap::CSS_TABLE_STRIPED, Bootstrap::CSS_MT5])])
            ->setPaginate($paginate)
            ->addHeader([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_WEAPONS])
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_DAMAGES])
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_PROPERTIES])
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_WEAPON_PROP])
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_WEIGHT])
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_PRICE]);

        if ($rpgWeapons->valid()) {
            $objTable->addBodyRows($rpgWeapons, 6);
        }

        return $objTable;
    }

    public function addBodyRow(Table &$objTable, array $arrParams, int &$oldTypeWeaponId): void
    {
        // Dégâts
        $strDegats = $this->rpgWeapon->getField(Field::DAMAGE);
        $objTypeDamage = $this->rpgWeapon->getTypeDamage();
        $strDegats .= ' '.strtolower($objTypeDamage->getField(Field::NAME)).'s';

        // Propriétés
        $objsWeaponWeaponProficiency = $this->rpgWeapon->getWeaponProficiencies();
        if (!$objsWeaponWeaponProficiency->valid()) {
            $strProprietes = '-';
        } else {
            $strProprietes = '';
            $objsWeaponWeaponProficiency->rewind();
            while ($objsWeaponWeaponProficiency->valid()) {
                $objWeaponWeaponProficiency = $objsWeaponWeaponProficiency->current();
                $strProprietes .= $objWeaponWeaponProficiency->getStrName().', ';
                $objsWeaponWeaponProficiency->next();
            }
            $strProprietes = substr($strProprietes, 0, -2);
        }

        // Botte d'arme
        $objMasteryProficiency = $this->rpgWeapon->getMasteryProficiency();
        $strBotteDArme = $objMasteryProficiency->getField(Field::NAME);

        $typeWeaponId = 10*$this->rpgWeapon->getField(Field::MELEE)+$this->rpgWeapon->getField(Field::MARTIAL);
        if ($oldTypeWeaponId!=$typeWeaponId) {
            $libelle = Language::LG_WEAPONS
                .($this->rpgWeapon->getField(Field::MARTIAL)==1 ? Language::LG_DAMAGES : Language::LG_WEAPON_SIMPLE)
                .($this->rpgWeapon->getField(Field::MELEE)==1 ? Language::LG_WEAPON_MELEE : Language::LG_WEAPON_RANGED);
            $objTable->addBodyRow()
                ->addBodyCell([Constant::CST_CONTENT=>$libelle, 'attributes'=>['colspan'=>6, Constant::CST_CLASS=>Bootstrap::CSS_FONT_ITALIC]]);
        }
        
        $objTable->addBodyRow()
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgWeapon->getField(Field::NAME)])
            ->addBodyCell([Constant::CST_CONTENT=>$strDegats])
            ->addBodyCell([Constant::CST_CONTENT=>$strProprietes])
            ->addBodyCell([Constant::CST_CONTENT=>$strBotteDArme])
            ->addBodyCell([Constant::CST_CONTENT=>Utils::getStrWeight($this->rpgWeapon->getField(Field::WEIGHT)), 'attributes'=>[Constant::CST_CLASS=>Bootstrap::CSS_TEXT_END]])
            ->addBodyCell([Constant::CST_CONTENT=>Utils::getStrPrice($this->rpgWeapon->getField(Field::GOLDPRICE)), 'attributes'=>[Constant::CST_CLASS=>Bootstrap::CSS_TEXT_END]]);

        $oldTypeWeaponId = $typeWeaponId;
    }
}
