<?php
namespace src\Controller;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Entity\RpgOrigin as EntityRpgOrigin;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;
use src\Utils\Table;

class RpgOrigin extends Utilities
{
    protected EntityRpgOrigin $rpgOrigin;

    public function __construct()
    {
        parent::__construct();

        $this->title = Language::LG_ORIGINS;
    }

    public static function getAdminContentPage(array $params): string
    {
        $objTable = static::getTable($params);
        return $objTable?->display();
    }

    public static function getTable(array $params): Table
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgOrigin($queryBuilder, $queryExecutor);
        $sortAttributes = [Field::NAME=>Constant::CST_ASC];
        $rpgFeats = $objDao->findAll($sortAttributes);
        $curPage      = $params[Constant::CST_CURPAGE] ?? 1;
        $nbPerPage    = $params[Constant::PAGE_NBPERPAGE] ?? 10;
        $refElementId = $params['refElementId'] ?? ($curPage-1)*$nbPerPage+1;
        
        if (($curPage-1)*$nbPerPage>$refElementId || $curPage*$nbPerPage<$refElementId) {
            $curPage = floor(($refElementId-1)/$nbPerPage)+1;
        }
        
        $paginate = [
            Constant::PAGE_OBJS      => $rpgFeats,
            Constant::CST_CURPAGE    => $curPage ?? 1,
            Constant::PAGE_NBPERPAGE => $nbPerPage
        ];
        $refElementId = ($curPage-1)*$nbPerPage + 1;
        $objTable = new Table();
        $objTable->setTable([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_SM, Bootstrap::CSS_TABLE_STRIPED, Bootstrap::CSS_MT5])])
            ->setPaginate($paginate)
            ->addHeader([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->setNbPerPage($refElementId, $nbPerPage)
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_ORIGINS])
            ->addHeaderCell([Constant::CST_CONTENT=>'Caractéristiques'])
            ->addHeaderCell([Constant::CST_CONTENT=>"Don d'origine"])
            ->addHeaderCell([Constant::CST_CONTENT=>'Compétences'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Outils'])
;
        
        if ($rpgFeats->valid()) {
            $objTable->addBodyRows($rpgFeats, 5);
        }
        return $objTable;
    }

    public function addBodyRow(Table &$objTable): void
    {
        /////////////////////////////////////////////////////////////////////
        // Le nom
        $strName = $this->rpgOrigin->getField(Field::NAME);
        
        // La liste des caractéristiques
        $strAbilities = '';//$this->rpgOrigin->getCaracteristiques();
        
        // Le don d'origine rattaché
        $strOriginFeat = $this->rpgOrigin->getOriginFeat()->getField(Field::NAME);
        
        $strSkills = $this->rpgOrigin->getOriginSkills();
        $strTool = '';
                
        $objTable->addBodyRow()
            ->addBodyCell([Constant::CST_CONTENT=>$strName])
            ->addBodyCell([Constant::CST_CONTENT=>$strAbilities])
            ->addBodyCell([Constant::CST_CONTENT=>$strOriginFeat])
            ->addBodyCell([Constant::CST_CONTENT=>$strSkills])
            ->addBodyCell([Constant::CST_CONTENT=>$strTool])
            ;
    }

    public function getRadioForm(bool $checked=false): string
    {
        $id = $this->rpgOrigin->getField(Field::ID);
        $name = $this->rpgOrigin->getField(Field::NAME);
        return '<div class="form-check">'
                . '<input class="ajaxAction" data-trigger="click" data-type="origin" type="radio" name="characterOriginId" value="'.$id.'" id="origin'.$id.'"'.($checked?' checked':'').'>'
                . '<label class="form-check-label" for="origin'.$id.'">'.$name.'</label>'
                . '</div>';
    }
    
    public function getDescription(): string
    {
        $originAbilities = $this->rpgOrigin->getOriginAbilities();
        $partAbilities = [];
        foreach ($originAbilities as $originAbility) {
            $partAbilities[] = $originAbility->getAbility()->getField(Field::NAME);
        }
        $originName = $this->rpgOrigin->getOriginFeat()->getField(Field::NAME);
        $originSkills = $this->rpgOrigin->getOriginSkills();
        $partSkills = [];
        foreach ($originSkills as $originSkill) {
            $partSkills[] = $originSkill->getSkill()->getField(Field::NAME);
        }
        $toolName = $this->rpgOrigin->getOriginTool()->getField(Field::NAME);
        
        $returned = '<strong>Caractéristiques</strong> : '.implode(', ', $partAbilities).'.<br>';
        $returned .= '<strong>Don</strong> : '.$originName.'<br>';
        $returned .= '<strong>Compétences</strong> : '.implode(', ', $partSkills).'<br>';
        $returned .= '<strong>Outils</strong> : '.$toolName.'<br>';
        $returned .= '<strong>Equipement</strong> : WIP<br>';
        
        return $returned;
    }
}