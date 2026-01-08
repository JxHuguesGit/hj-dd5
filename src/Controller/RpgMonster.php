<?php
namespace src\Controller;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Icon;
use src\Constant\Template;
use src\Entity\RpgMonster as EntityRpgMonster;
use src\Entity\RpgMonsterResistance as EntityRpgMonsterResistance;
use src\Enum\MonsterTypeEnum;
use src\Form\RpgMonster as FormRpgMonster;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Presenter\MonsterPresenter;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Utils\Html;
use src\Utils\Session;
use src\Utils\Table;

class RpgMonster extends Utilities
{
    protected EntityRpgMonster $rpgMonster;

    public function __construct()
    {
        parent::__construct();

        $this->title = 'Monstres';
    }

    public static function getAdminContentPage(array $params): string
    {
        $controller = new self();

        $form = Session::fromPost('monsterFilter') ?? '';
        if ($form=='Filtrer') {
            $params[Constant::PAGE_NBPERPAGE] = Session::fromPost(Constant::PAGE_NBPERPAGE) ?? 10;
            $params['selectAllType'] = Session::fromPost('selectAllType')==1;
            $params['typeFilter'] = Session::fromPost('typeFilter', []);
            $params['fpMinFilter'] = Session::fromPost('fpMinFilter', 0);
            $params['fpMaxFilter'] = Session::fromPost('fpMaxFilter', 30);
            $params['monsterFilter'] = 'Filtrer';
        } else {
            $params['selectAllType'] = true;
            $params['typeFilter'] = array_map(fn($case) => $case->value, MonsterTypeEnum::cases());
            $params['fpMinFilter'] = 0;
            $params['fpMaxFilter'] = 30;
        }
        
        $formAction = $params['formAction'] ?? Session::fromPost('formAction', 'table');
        if ($formAction=='table') {
            $objTable = $controller->getTable($params);
            $pageContent = $objTable?->display();
        } elseif (in_array($formAction, ['edit', 'editConfirm'])) {
            $monsterId = $params['entityId'] ?? Session::fromPost('entityId', 'table');
            $queryBuilder  = new QueryBuilder();
            $queryExecutor = new QueryExecutor();
            $objDaoMonstre = new RepositoryRpgMonster($queryBuilder, $queryExecutor);
            $rpgMonstre = $objDaoMonstre->find($monsterId);
            $objForm = new FormRpgMonster($rpgMonstre);
            
            if ($formAction=='editConfirm') {
                $objForm->resolveForm();
                $rpgMonstre = $objDaoMonstre->find($monsterId);
                $objForm = new FormRpgMonster($rpgMonstre);
            }
            $pageContent = $objForm->getTemplate();
        } else {
            $pageContent = 'formAction non prévu.';
        }
        return $pageContent;
    }
    
    public function getFilter(array $params): string
    {
        // Liste des options de types de monstres
        $typeOptions = '';
        foreach (MonsterTypeEnum::cases() as $case) {
            $typeOptions .= '<option value="'.$case->value.'"'.(in_array($case->value, $params['typeFilter']) ? ' '.Constant::CST_SELECTED : '').'>'.ucfirst($case->label()).'</option>';
        }
        
        // Liste des niveaux
        $minOptions = '';
        $maxOptions = '';
        for ($i=0; $i<=30; $i++) {
            $minOptions .= '<option value="'.$i.'"'.($params['fpMinFilter']==$i ? ' '.Constant::CST_SELECTED : '').'>'.$i.'</option>';
            $maxOptions .= '<option value="'.$i.'"'.($params['fpMaxFilter']==$i ? ' '.Constant::CST_SELECTED : '').'>'.$i.'</option>';
        }
        
        $attributes = [
            '/wp-admin/admin.php?page=hj-dd5%2Fadmin_manage.php&onglet=compendium&id=monsters',
            $params['selectAllType'] ? ' checked' : '',
            count($params['typeFilter']),
            $typeOptions,
            //$params['selectAllSchool'] ? ' checked' : '',
            '',
            //count($params['schoolFilter']),
            '',
            //$schoolOptions,
            '',
            $minOptions,
            $maxOptions,
            //$params['onlyRituel'] ? ' checked' : '',
            '',
            //$params['onlyConcentration'] ? ' checked' : '',
            '',
            $params[Constant::PAGE_NBPERPAGE] ?? 10,
            $params['refElementId'],
        ];
        return $this->getRender(Template::FILTER_MONSTER, $attributes);
    }
    
    public function getTable(array $params): Table
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDaoMonstre = new RepositoryRpgMonster($queryBuilder, $queryExecutor);
        $objsMonstre = $objDaoMonstre->findBy($params, ["COALESCE(NULLIF(".Field::FRNAME.", ''), rpgMonster.".Field::NAME.")"=>Constant::CST_ASC]);
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
            Constant::PAGE_OBJS      => $objsMonstre,
            Constant::CST_CURPAGE    => $curPage ?? 1,
            Constant::PAGE_NBPERPAGE => $nbPerPage
        ];
        $refElementId = ($curPage-1)*$nbPerPage + 1;
        
        $objTable = new Table();
        $objTable->setTable([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_SM]), 'style'=>'margin-top:120px'])
            ->setPaginate($paginate, $params)
            ->addHeader([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->setNbPerPage($refElementId, $nbPerPage)
            ->setFilter($this->getFilter($params), 10)
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT=>'Monstres'])
            ->addHeaderCell([Constant::CST_CONTENT=>'CR'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Type'])
            ->addHeaderCell([Constant::CST_CONTENT=>'CA'])
            ->addHeaderCell([Constant::CST_CONTENT=>'HP'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Référence'])
            ->addHeaderCell([Constant::CST_CONTENT=>'&nbsp;'])
            ;

        $objTable->addBodyRows($objsMonstre, 7);

        return $objTable;
    }

    public function addBodyRow(Table &$objTable, array $arrParams): void
    {
        $presenter = new MonsterPresenter($this->rpgMonster);
        
        $htmlExtenion = '.html';
        $blnComplet = $this->rpgMonster->getField(Field::INCOMPLET)==0;
        /////////////////////////////////////////////////////////////////////
        // Le nom
        if ($blnComplet && $this->rpgMonster->getField(Field::FRNAME)!='') {
            $strName = $this->rpgMonster->getField(Field::FRNAME);
        } else {
            $strName = $this->rpgMonster->getField(Field::NAME);
        }
        $strName = '<span class="modal-tooltip" data-modal="monster" data-uktag="id-'.$this->rpgMonster->getField(Field::ID).'">'.$strName.' <span class="fa fa-search"></span></span>';

        //////////////////
        if (!$blnComplet) {
            // On va récupérer les fichiers du monstre sur aidedd.org
            $urlDistante = 'https://www.aidedd.org/monster/';
            $urlLocale = '../wp-content/plugins/hj-dd5/assets/aidedd/';
            //////////////////
            // La version anglaise
            $ukTag = $this->rpgMonster->getField(Field::UKTAG);
            $handleUk = fopen($urlLocale.$ukTag.$htmlExtenion, 'r');
            if ($handleUk===false) {
                $content = file_get_contents($urlDistante.$ukTag);
                $urlDestination = '../wp-content/plugins/hj-dd5/assets/aidedd/'.$ukTag.$htmlExtenion;
                file_put_contents($urlDestination, $content);
            }

                $strName .= '<i class="float-end" data-modal="monster" data-uktag="'.$ukTag.'">🇬🇧</i>';

            //////////////////
            // La version française
            $frTag = $this->rpgMonster->getField(Field::FRTAG);
            if ($frTag!='non') {
                $handleFr = fopen($urlLocale.$ukTag.$htmlExtenion, 'r');
                if ($handleFr===false) {
                    $content = file_get_contents($urlDistante.$frTag);
                    $urlDestination = '../wp-content/plugins/hj-dd5/assets/aidedd/fr-'.$frTag.$htmlExtenion;
                    file_put_contents($urlDestination, $content);
                } else {
                    $strName .= '<i class="float-end" data-modal="monster" data-uktag="fr-'.$frTag.'">🇫🇷</i>';
                }
            }
        }
        /////////////////////////////////////////////////////////////////////

        // Le CR
        $strCr = $presenter->getCR();

        // Le type de monstre
        $strType = $presenter->getStrType();

        // La taille
        //$strSize = SizeHelper::toLabelFr($this->rpgMonster->getField(Field::MSTSIZE));

        // La CA
        $strCA = $this->rpgMonster->getField(Field::SCORECA);

        // Les HP
        $strHP = $this->rpgMonster->getField(Field::SCOREHP);

        // L'alignement
        //$objAlignement = $this->rpgMonster->getAlignement();
        //$strAlignement = $objAlignement->getStrAlignement();

        // Légendaire ?
        //$strLegendaire = $this->rpgMonster->getField(Field::LEGENDARY)==1 ? 'Légendaire' : '';

        // Habitat
        //$strHabitat = $this->rpgMonster->getField(Field::HABITAT);

        // Référence
        $objReference = $presenter->getReference();
        $strReference = $objReference?->getName() ?? '';
        
        // Actions
        $label = Html::getIcon(Icon::IBOOK);
        $href = add_query_arg('formAction', 'edit');
        $href = add_query_arg('entityId', $this->rpgMonster->getField(Field::ID), $href);
        $strActions = Html::getLink($label, $href, '');

        $objTable->addBodyRow($arrParams)
            ->addBodyCell([Constant::CST_CONTENT=>$strName])
            ->addBodyCell([Constant::CST_CONTENT=>$strCr, 'attributes'=>[Constant::CST_CLASS=>'text-center']])
            ->addBodyCell([Constant::CST_CONTENT=>$strType])
            //->addBodyCell([Constant::CST_CONTENT=>$strSize])
            ->addBodyCell([Constant::CST_CONTENT=>$strCA, 'attributes'=>[Constant::CST_CLASS=>'text-center']])
            ->addBodyCell([Constant::CST_CONTENT=>$strHP, 'attributes'=>[Constant::CST_CLASS=>'text-end']])
            //->addBodyCell([Constant::CST_CONTENT=>''])//$matches[8]])
            //->addBodyCell([Constant::CST_CONTENT=>$strAlignement])
            //->addBodyCell([Constant::CST_CONTENT=>$strLegendaire])
            //->addBodyCell([Constant::CST_CONTENT=>$strHabitat])
            ->addBodyCell([Constant::CST_CONTENT=>$strReference])
            ->addBodyCell([Constant::CST_CONTENT=>$strActions])
            ;
    }
    
    public function getMonsterCard(): string
    {
        $presenter = new MonsterPresenter($this->rpgMonster);
        $objsTrait = $presenter->getTraits();
        $objsActions = $presenter->getActions();
        $objsBonusActions = $presenter->getBonusActions();
        $objsReactions = $presenter->getReactions();
        $objsActionsLegendaires = $presenter->getLegendaryActions();

        $attributes = [
            $presenter->getStrName(),
            '',//$presenter->getSizeTypeAndAlignement(),
            '',//$presenter->getStrExtra(Field::SCORECA),
            '',//$presenter->getStrInitiative(),
            '',//$presenter->getStrExtra(Field::SCOREHP),
            '',//$presenter->getStrVitesse(),
            $presenter->getScore('str'),
            $presenter->getScore('dex'),
            $presenter->getScore('con'),
            $presenter->getScore('int'),
            $presenter->getScore('wis'),
            $presenter->getScore('cha'),
            '',//$this->getSkillsToCR(),
            // d-none si pas de Traits
            empty($objsTrait) ? ' '.Bootstrap::CSS_DNONE : '',
            //$this->getSpecialAbilitiesList($objsTrait), // Liste des traits
            '',
            // d-none si pas d'Actions
            empty($objsActions) ? ' '.Bootstrap::CSS_DNONE : '',
             // Liste des actions
            '',//$this->getSpecialAbilitiesList($objsActions),
            // d-none si pas de Bonus actions
            empty($objsBonusActions) ? ' '.Bootstrap::CSS_DNONE : '',
            //$this->getSpecialAbilitiesList($objsBonusActions), // Liste des Bonus actions
            '',
            // d-none si pas de Réactions
            empty($objsReactions) ? ' '.Bootstrap::CSS_DNONE : '',
            //$this->getSpecialAbilitiesList($objsReactions), // Liste des Réactions
            '',
            // d-none si pas de Legendary Actions
            empty($objsActionsLegendaires) ? ' '.Bootstrap::CSS_DNONE : '',
            //$this->getSpecialAbilitiesList($objsActionsLegendaires), // Liste des Actions Légendaires
            '',
            '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
        ];
        return $this->getRender(Template::MONSTER_CARD, $attributes);
    }
    
    private function getSkills(): string
    {
        $str = '';
        //////////////////////////////////////////////////////////////
        // Gestion des compétences du monstre
        $objs = $this->rpgMonster->getSkills();
        $skills = $this->rpgMonster->getExtra('skills');
        if (!$objs->isEmpty() || $skills!='') {
            $str .= '<div class="col-12"><strong>Compétences</strong> ';
            $comma = false;
            $objs->rewind();
            while ($objs->valid()) {
                if ($comma) {
                    $str .= ', ';
                }
                $obj = $objs->current();
                $str .= $obj->getController()->getFormatString();
                $comma = true;
                $objs->next();
            }
            if ($skills!='') {
                $str .= ($comma ? ', ' : '').$skills;
            }
            $str .= '</div>';
        }
        //////////////////////////////////////////////////////////////
        return $str;
    }

    private function getResistances(string $type, string $label, string $tag): string
    {
        $objs = $this->rpgMonster->getResistances($type);
        $extra = $this->rpgMonster->getExtra($tag);

        if ($objs->isEmpty() && $extra === '') {
            return '';
        }

        $damageTypes = [];
        $conditions  = [];

        foreach ($objs as $obj) {
            if ($obj instanceof EntityRpgMonsterResistance) {
                $damageTypes[] = $obj->getTypeDamage()->getField(Field::NAME);
            } else {
                $conditions[] = $obj->getCondition()->getField(Field::NAME);
            }
        }

        $parts = [];

        if (!empty($damageTypes)) {
            $parts[] = implode(', ', $damageTypes);
        }

        if (!empty($conditions)) {
            $parts[] = implode(', ', $conditions);
        }

        if ($extra !== '') {
            $parts[] = $extra;
        }

        // Types de dégâts et conditions séparés par un point-virgule
        $content = implode(' ; ', $parts);

        return '<div class="col-12"><strong>' . $label . '</strong> ' . $content . '</div>';
    }

    private function getSenses(): string
    {
        $str = '';
        //////////////////////////////////////////////////////////////
        // Gestion des sens du monstre
        $str .= '<div class="col-12"><strong>Sens</strong> ';
        $objs = $this->rpgMonster->getSenses();
        if (!$objs->isEmpty()) {
            $comma = false;
            $objs->rewind();
            while ($objs->valid()) {
                if ($comma) {
                    $str .= ', ';
                }
                $obj = $objs->current();
                $str .= $obj->getController()->getFormatString();
                $comma = true;
                $objs->next();
            }
        }
        $senses = $this->rpgMonster->getExtra('senses');
        if ($senses!='') {
            $str .= ($comma ? ', ' : '').$senses;
            $comma = true;
        }
        $percPassive = $this->rpgMonster->getField(Field::PERCPASSIVE);
        $str .= ($comma ? ', ' : '') . 'Perception passive ' . $percPassive;
        $str .= '</div>';
        //////////////////////////////////////////////////////////////
        return $str;
    }

    private function getSkillsToCR(): string
    {
        $str  = '';
        // Gestion des compétences du monstre
        $str .= $this->getSkills();
        
        // Gestion des résistances du monstre
        $str .= $this->getResistances('R', 'Résistances', 'resistances');
        // Gestion des immunités du monstre
        $str .= $this->getResistances('I', 'Immunités', 'immunities');
        // Gestion des sens du monstre
        $str .= $this->getSenses();

        //////////////////////////////////////////////////////////////
        // Gestion des langues du monstre
        $objs = $this->rpgMonster->getLanguages();
        $languages = $this->rpgMonster->getExtra('languages');
        $str .= '<div class="col-12"><strong>Langues</strong> ';
        if (!$objs->isEmpty() || $languages!='') {
            $comma = false;
            $objs->rewind();
            while ($objs->valid()) {
                if ($comma) {
                    $str .= ', ';
                }
                $obj = $objs->current();
                $str .= $obj->getController()->getStrLanguage();
                $comma = true;
                $objs->next();
            }
            if ($languages!='') {
                $str .= ($comma ? ', ' : '').$languages;
            }
        } else {
            $str .= 'Aucune';
        }
        $str .= '</div>';
        //////////////////////////////////////////////////////////////
        
        //////////////////////////////////////////////////////////////
        $bm = $this->rpgMonster->getField(Field::PROFBONUS);
        $extraPx = $this->rpgMonster->getExtra('xp');
        $extraPb = $this->rpgMonster->getExtra('pb');
        
        $str .= '<div class="col-12"><strong>FP</strong> '.$this->rpgMonster->getFormatCr();
        $str .= ' (PX '.$this->rpgMonster->getTotalXp().$extraPx;
        $str .= ' ; BM ' . ($bm==0 ? '' : '+'.$bm) . $extraPb.')</div>';
        //////////////////////////////////////////////////////////////
        
        return $str;
    }
    
    private function getSpecialAbilitiesList(array $objs): string
    {
        $str = '';
        foreach ($objs as $obj) {
            $str .= $obj->getController()->getFormatString();
        }
        return $str;
    }
    
}
