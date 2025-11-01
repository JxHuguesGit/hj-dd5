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
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_ORIGINS]);
        
        if ($rpgFeats->valid()) {
            $objTable->addBodyRows($rpgFeats, 1);
        }
        return $objTable;
    }

    public function addBodyRow(Table &$objTable): void
    {
        /////////////////////////////////////////////////////////////////////
        // Le nom
        $strName = $this->rpgOrigin->getField(Field::NAME);
                
        $objTable->addBodyRow()
            ->addBodyCell([Constant::CST_CONTENT=>$strName]);
    }
}
