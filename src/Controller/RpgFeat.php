<?php
namespace src\Controller;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Entity\RpgFeat as EntityRpgFeat;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgFeat as RepositoryRpgFeat;
use src\Utils\Table;
use src\Utils\Utils;

class RpgFeat extends Utilities
{
    protected EntityRpgFeat $rpgFeat;

    public function __construct()
    {
        parent::__construct();

        $this->title = Language::LG_FEATS;
    }
    
    public static function getTable(array $params): Table
    {
    	/*
        $tri = $params['tri']??Field::NAME;
        //
        $ordre = $params['ordre']??Constant::CST_ASC;
        if ($ordre!=Constant::CST_DESC) {
        	$ordre = Constant::CST_ASC;
        }
    	$sortAttributes = [$tri=>$ordre];
        */
    	$sortAttributes = [Field::NAME=>Constant::CST_ASC];
        
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgFeat($queryBuilder, $queryExecutor);
        $rpgFeats = $objDao->findAll($sortAttributes);
		$paginate = [
        	Constant::PAGE_OBJS      => $rpgFeats,
            Constant::CST_CURPAGE    => $params[Constant::CST_CURPAGE] ?? 1
        ];

        $objTable = new Table();
        $objTable->setTable([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_SM, Bootstrap::CSS_TABLE_STRIPED, Bootstrap::CSS_MT5])])
	        ->setPaginate($paginate)
            ->addHeader([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow()
            ->addHeaderCell([
                Constant::CST_CONTENT=>Language::LG_FEATS,
                /*
                Constant::CST_ATTRIBUTES=>[
                	Constant::CST_CLASS=>'dt-orderable-asc dt-orderable-desc dt-ordering-asc',
                    'data-sortable' => Field::NAME
                ]
                */
            ])
            ->addHeaderCell([
            	Constant::CST_CONTENT=>Language::LG_CATEGORY,
                /*
                Constant::CST_ATTRIBUTES=>[
                	Constant::CST_CLASS=>'dt-orderable-asc dt-orderable-desc dt-ordering-desc',
                    'data-sortable' => Field::FEATTYPEID
                ]
                */
            ]);
        
        if ($rpgFeats->valid()) {
            $objTable->addBodyRows($rpgFeats, 2);
        }
        return $objTable; 
    }

    public function addBodyRow(Table &$objTable): void
    {
    	$strFeatType = $this->rpgFeat->getFeatType()->getField(Field::NAME);
        
        $objTable->addBodyRow()
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgFeat->getField(Field::NAME)])
            ->addBodyCell([Constant::CST_CONTENT=>$strFeatType]);
    }
}