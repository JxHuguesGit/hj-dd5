<?php
namespace src\Controller;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Constant\Template;
use src\Entity\RpgSpell as EntityRpgSpell;
use src\Enum\ClassEnum;
use src\Enum\MagicSchoolEnum;
use src\Repository\RpgSpell as RepositoryRpgSpell;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Utils\Session;
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
        $controller = new self();

        $form = Session::fromPost('spellFilter') ?? '';
        if ($form=='Filtrer') {
            $params[Constant::PAGE_NBPERPAGE] = Session::fromPost(Constant::PAGE_NBPERPAGE) ?? 10;
            $params['selectAllClass'] = Session::fromPost('selectAllClass')==1;
            $params['classFilter'] = Session::fromPost('classFilter', []);
            $params['selectAllSchool'] = Session::fromPost('selectAllSchool')==1;
            $params['schoolFilter'] = Session::fromPost('schoolFilter', []);
            $params['levelMinFilter'] = Session::fromPost('levelMinFilter', 0);
            $params['levelMaxFilter'] = Session::fromPost('levelMaxFilter', 9);
            $params['onlyRituel'] = Session::fromPost('onlyRituel', 0);
            $params['onlyConcentration'] = Session::fromPost('onlyConcentration', 0);
            $params['spellFilter'] = 'Filtrer';
        } else {
            $params['selectAllClass'] = true;
            $params['classFilter'] = array_map(fn($case) => $case->value, array_filter(ClassEnum::cases(), fn($case) => !in_array($case, [ClassEnum::Bab, ClassEnum::Gue, ClassEnum::Moi, ClassEnum::Rou])));
            $params['selectAllSchool'] = true;
            $params['schoolFilter'] = array_map(fn($case) => $case->value, MagicSchoolEnum::cases());
            $params['levelMinFilter'] = 0;
            $params['levelMaxFilter'] = 9;
            $params['onlyRituel'] = 0;
            $params['onlyConcentration'] = 0;
        }
        $objTable = $controller->getTable($params);
        return $objTable?->display();
    }
    
    public function getFilter(array $params): string
    {
        // Liste des options de classes.
        $classOptions = '';
        foreach (ClassEnum::cases() as $case) {
            if (in_array($case, [ClassEnum::Bab, ClassEnum::Gue, ClassEnum::Moi, ClassEnum::Rou])) {
                continue;
            }
            $value = $case->value;
            $classOptions .= '<option value="'.$value.'"'.(in_array($value, $params['classFilter']) ? ' '.Constant::CST_SELECTED : '').'>'.ucfirst($case->label()).'</option>';
        }

        // Liste des options d'écoles
        $schoolOptions = '';
        foreach (MagicSchoolEnum::cases() as $case) {
            $schoolOptions .= '<option value="'.$case->value.'"'.(in_array($case->value, $params['schoolFilter']) ? ' '.Constant::CST_SELECTED : '').'>'.ucfirst($case->label()).'</option>';
        }
        
        // Liste des niveaux
        $minOptions = '';
        $maxOptions = '';
        for ($i=0; $i<=9; $i++) {
            $minOptions .= '<option value="'.$i.'"'.($params['levelMinFilter']==$i ? ' '.Constant::CST_SELECTED : '').'>'.$i.'</option>';
            $maxOptions .= '<option value="'.$i.'"'.($params['levelMaxFilter']==$i ? ' '.Constant::CST_SELECTED : '').'>'.$i.'</option>';
        }
        
        $attributes = [
            '/wp-admin/admin.php?page=hj-dd5%2Fadmin_manage.php&onglet=compendium&id=spells', // Url du formulaire
            $params['selectAllClass'] ? ' '.Constant::CST_CHECKED : '',
            count($params['classFilter']),
            $classOptions,
            $params['selectAllSchool'] ? ' '.Constant::CST_CHECKED : '',
            count($params['schoolFilter']),
            $schoolOptions,
            $minOptions,
            $maxOptions,
            $params['onlyRituel'] ? ' '.Constant::CST_CHECKED : '',
            $params['onlyConcentration'] ? ' '.Constant::CST_CHECKED : '',
            $params[Constant::PAGE_NBPERPAGE] ?? 10,
            $params['refElementId'],
        ];
        return $this->getRender(Template::FILTER_SPELL, $attributes);
    }
        
    public function getTable(array $params): Table
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgSpell($queryBuilder, $queryExecutor);
        $rpgSpells = $objDao->findBy($params);
        $curPage      = $params[Constant::CST_CURPAGE] ?? 1;
        $nbPerPage    = $params[Constant::PAGE_NBPERPAGE] ?? 10;
        $refElementId = $params['refElementId'] ?? ($curPage-1)*$nbPerPage+1;
        if (!isset($params['refElementId'])) {
            $params['refElementId'] = $refElementId;
        }
        
        if (($curPage-1)*$nbPerPage>$refElementId || $curPage*$nbPerPage<$refElementId) {
            $curPage = floor(($refElementId-1)/$nbPerPage)+1;
        }
        
        $paginate = [
            Constant::PAGE_OBJS      => $rpgSpells,
            Constant::CST_CURPAGE    => $curPage ?? 1,
            Constant::PAGE_NBPERPAGE => $nbPerPage
        ];
        $refElementId = ($curPage-1)*$nbPerPage + 1;

        $objTable = new Table();
        $objTable->setTable([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_SM]), 'style'=>'margin-top:120px'])
            ->setPaginate($paginate, $params)
            ->addHeader([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->setNbPerPage($refElementId, $nbPerPage, [], 10)
            ->setFilter($this->getFilter($params), 10)
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_SPELLS, Constant::CST_ATTRIBUTES=>[Constant::CST_CLASS=>Bootstrap::CSS_COL_MD_3]])
            ->addHeaderCell([Constant::CST_CONTENT=>'Niveau'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Ecole'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Classe'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Incantation'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Portée'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Durée'])
            ->addHeaderCell([Constant::CST_CONTENT=>'V,S,M'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Concentration'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Rituel']);
        if ($rpgSpells->valid()) {
            $objTable->addBodyRows($rpgSpells, 10);
        }

        return $objTable;
    }

    public function addBodyRow(Table &$objTable, array $arrParams): void
    {
        $strName = '<span class="modal-tooltip" data-modal="spell" data-uktag="'.$this->rpgSpell->getField(Field::ID).'">'.$this->rpgSpell->getTitle().' <span class="fa fa-search"></span></span>';
        
        $strEcole = $this->rpgSpell->getEcole();
        
        $objTable->addBodyRow($arrParams)
            ->addBodyCell([Constant::CST_CONTENT=>$strName])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getNiveau(), Constant::CST_ATTRIBUTES=>[Constant::CST_CLASS=>'text-center']])
            ->addBodyCell([Constant::CST_CONTENT=>MagicSchoolEnum::labelFromDb($strEcole)])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getFormattedClasses(false)])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getFormattedIncantation()])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getFormattedPortee()])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getFormattedDuree(false)])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getFormattedComposantes(false)])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getStrConcentration()])
            ->addBodyCell([Constant::CST_CONTENT=>$this->rpgSpell->getStrRituel()]);
    }
    
    public function getSpellCard(): string
    {
        $typeAmelioration = $this->rpgSpell->getTypeAmelioration();
        $attributes = [
            $this->rpgSpell->getTitle(),
            $this->getStrEcole(),
            $this->rpgSpell->getFormattedIncantation(),
            $this->rpgSpell->getFormattedPortee(),
            $this->rpgSpell->getFormattedComposantes(),
            $this->rpgSpell->getFormattedDuree(),
            $this->rpgSpell->getDescription(),
            ($typeAmelioration=='spell' ? '' : Bootstrap::CSS_DNONE),
            $this->rpgSpell->getAmelioration(),
        ];
        
        return $this->getRender(Template::SPELL_CARD, $attributes);
    }
    
    private function getStrEcole(): string
    {
        $str  = MagicSchoolEnum::labelFromDb($this->rpgSpell->getEcole());
        $str .= ' de niveau '.$this->rpgSpell->getNiveau();
        $str .= ' '.$this->rpgSpell->getFormattedClasses();
        return $str;
    }

}
