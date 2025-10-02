<?php
namespace src\Controller;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Icon;
use src\Constant\Language;
use src\Entity\RpgSkill as EntityRpgSkill;
use src\Repository\RpgSkill as RepositoryRpgSkill;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Utils\Html;
use src\Utils\Table;

class RpgSkill extends Utilities
{
    protected EntityRpgSkill $rpgSkill;

    public function __construct()
    {
        parent::__construct();

        $this->title = Language::LG_SKILLS;
    }

    public function getContentPage(): string
    {
        return 'WIP RpgSkill::getContentPage';
    }
    
    public static function getTable(array $params): Table
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgSkill($queryBuilder, $queryExecutor);
        $rpgSkills = $objDao->findAll([Field::NAME=>Constant::CST_ASC]);

		$paginate = [
        	Constant::PAGE_OBJS      => $rpgSkills,
            Constant::CST_CURPAGE    => $arrParams[Constant::CST_CURPAGE] ?? 1,
        ];

        $objTable = new Table();
        $objTable->setTable([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_SM, Bootstrap::CSS_MT5])])
	        ->setPaginate($paginate)
            ->addHeader([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_SKILLS, Constant::CST_ATTRIBUTES=>[Constant::CST_COLSPAN=>2, Constant::CST_CLASS=>Bootstrap::CSS_COL_MD_3]])
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_ABILITIES, Constant::CST_ATTRIBUTES=>[Constant::CST_CLASS=>Bootstrap::CSS_COL_MD_9]]);

        if ($rpgSkills->valid()) {
            $objTable->addBodyRows($rpgSkills, 4);
        }

        return $objTable;
    }

    public function addBodyRow(Table &$objTable, array $arrParams): void
    {
        // Nom de la caractéristique
        $objAbility = $this->rpgSkill->getAbility();
        $strName = $objAbility->getField(Field::NAME);

        $objTable->addBodyRow($arrParams)
            ->addBodyCell([Constant::CST_CONTENT=>Html::getIcon(Icon::ISQUAREPLUS, Icon::REGULAR, ['data-target'=>$this->rpgSkill->getField(Field::ID)])])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSkill->getField(Field::NAME), Constant::CST_ATTRIBUTES=>[Constant::CST_CLASS=>Bootstrap::CSS_COL_MD_2]])
            ->addBodyCell([Constant::CST_CONTENT=>$strName, Constant::CST_ATTRIBUTES=>[Constant::CST_CLASS=>Bootstrap::CSS_COL_MD_9]]);
        
        // On récupère les sous-compétences de la compétence courante
        $subSkills = $this->rpgSkill->getSubSkills();

        $subSkills->rewind();
        $cpt = 1;
        while ($subSkills->valid()) {
            $subSkill = $subSkills->current();
            $objTable->addBodyRow([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_DNONE, ($cpt%2==0 ? Bootstrap::CSS_ROW_PRIMARY_STRIPED_EVEN : Bootstrap::CSS_ROW_PRIMARY_STRIPED_ODD)]), 'data'=>['parent'=>$this->rpgSkill->getField(Field::ID)]])
                ->addBodyCell([Constant::CST_CONTENT=>'&nbsp;'])
                ->addBodyCell([Constant::CST_CONTENT=>$subSkill->getField(Field::NAME), Constant::CST_ATTRIBUTES=>[Constant::CST_CLASS=>Bootstrap::CSS_COL_MD_2]])
                ->addBodyCell([Constant::CST_CONTENT=>$subSkill->getField(Field::DESCRIPTION), Constant::CST_ATTRIBUTES=>[Constant::CST_CLASS=>Bootstrap::CSS_COL_MD_9]]);
            ++$cpt;
            $subSkills->next();
        }


    }
}