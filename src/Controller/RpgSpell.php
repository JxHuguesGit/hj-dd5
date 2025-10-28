<?php
namespace src\Controller;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Constant\Template;
use src\Entity\RpgSpell as EntityRpgSpell;
use src\Enum\MagicSchoolEnum;
use src\Repository\RpgSpell as RepositoryRpgSpell;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Utils\Table;

class RpgSpell extends Utilities
{
    protected EntityRpgSpell $rpgSpell;

    public function __construct()
    {
        parent::__construct();

        $this->title = Language::LG_SPELLS;
    }

    public function getContentPage(): string
    {
        return 'WIP RpgSpell::getContentPage';
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
        $objDao = new RepositoryRpgSpell($queryBuilder, $queryExecutor);
        $rpgSpells = $objDao->findAll();

        $paginate = [
            Constant::PAGE_OBJS      => $rpgSpells,
            Constant::CST_CURPAGE    => $params[Constant::CST_CURPAGE] ?? 1,
        ];

        $objTable = new Table();
        $objTable->setTable([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_SM, Bootstrap::CSS_MT5])])
            ->setPaginate($paginate)
            ->addHeader([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_SPELLS, Constant::CST_ATTRIBUTES=>[Constant::CST_CLASS=>Bootstrap::CSS_COL_MD_3]])
            ->addHeaderCell([Constant::CST_CONTENT=>'Niveau'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Ecole'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Incantation'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Portée'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Durée'])
            ->addHeaderCell([Constant::CST_CONTENT=>'V,S,M'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Concentration'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Rituel']);
        if ($rpgSpells->valid()) {
            $objTable->addBodyRows($rpgSpells, 9);
        }

        return $objTable;
    }

    public function addBodyRow(Table &$objTable, array $arrParams): void
    {
        $strName = '<span class="modal-tooltip" data-modal="spell" data-uktag="'.$this->rpgSpell->getId().'">'.$this->rpgSpell->getTitle().' <span class="fa fa-search"></span></span>';
        
        $strEcole = $this->rpgSpell->getEcole();
        
        $objTable->addBodyRow($arrParams)
            ->addBodyCell([Constant::CST_CONTENT=>$strName])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getNiveau(), Constant::CST_ATTRIBUTES=>[Constant::CST_CLASS=>'text-center']])
            ->addBodyCell([Constant::CST_CONTENT=>MagicSchoolEnum::fromDb($strEcole)])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getFormattedIncantation()])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getFormattedPortee()])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getFormattedDuree(false)])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getFormattedComposantes(false)])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getStrConcentration()])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getStrRituel()]);
    }
    
    public function getSpellCard(): string
    {
        $attributes = [
            $this->rpgSpell->getTitle(),
            $this->getStrEcole(),
            $this->rpgSpell->getFormattedIncantation(),
            $this->rpgSpell->getFormattedPortee(),
            $this->rpgSpell->getFormattedComposantes(),
            $this->rpgSpell->getFormattedDuree(),
            $this->rpgSpell->getDescription(),
            'wip',
        ];
        
        return $this->getRender(Template::SPELL_CARD, $attributes);
    }
    
    private function getStrEcole(): string
    {
        $str  = MagicSchoolEnum::fromDb($this->rpgSpell->getEcole());
        $str .= ' de niveau '.$this->rpgSpell->getNiveau();
        $str .= ' '.$this->rpgSpell->getFormattedClasses();
        return $str;
    }

}
