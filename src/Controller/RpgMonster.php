<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\RpgMonster as EntityRpgMonster;
use src\Form\RpgMonster as FormRpgMonster;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Helper\SizeHelper;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
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
    	$formAction = $params['formAction'] ?? 'table';
        if ($formAction=='table') {
	    	$objTable = self::getTable($params);
            $pageContent = $objTable?->display();
        } elseif ($formAction=='edit') {
        	$monsterId = $params['entityId'];
            $queryBuilder  = new QueryBuilder();
            $queryExecutor = new QueryExecutor();
            $objDaoMonstre = new RepositoryRpgMonster($queryBuilder, $queryExecutor);
        	$rpgMonstre = $objDaoMonstre->find($monsterId);
            
        	$objForm = new FormRpgMonster($rpgMonstre);
            $objForm->buildForm();
            $pageContent = $objForm->getFormContent();
        } else {
        	$pageContent = 'formAction non prévu.';
        }
        return $pageContent;
    }
    
    public static function getTable(array $params): Table
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDaoMonstre = new RepositoryRpgMonster($queryBuilder, $queryExecutor);
        $objsMonstre = $objDaoMonstre->findAll();
        $curPage      = $params[Constant::CST_CURPAGE] ?? 1;
        $nbPerPage    = $params[Constant::PAGE_NBPERPAGE] ?? 10;
        $refElementId = $params['refElementId'] ?? ($curPage-1)*$nbPerPage+1;
        
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
        $objTable->setTable([Constant::CST_CLASS=>'table-sm table-striped mt-5'])
            ->setPaginate($paginate)
            ->addHeader([Constant::CST_CLASS=>'table-dark text-center'])
            ->setNbPerPage($refElementId, $nbPerPage)
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT=>'Monstres'])
            ->addHeaderCell([Constant::CST_CONTENT=>'CR'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Type'])
            //->addHeaderCell([Constant::CST_CONTENT=>'Taille'])
            ->addHeaderCell([Constant::CST_CONTENT=>'CA'])
            ->addHeaderCell([Constant::CST_CONTENT=>'HP'])
            //->addHeaderCell([Constant::CST_CONTENT=>'Vitesse'])
            //->addHeaderCell([Constant::CST_CONTENT=>'Alignement'])
            //->addHeaderCell([Constant::CST_CONTENT=>'Légendaire'])
            //->addHeaderCell([Constant::CST_CONTENT=>'Habitat'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Référence']);

        //$this->parseFileSource($objTable);

        $objTable->addBodyRows($objsMonstre, 6);

        return $objTable;
    }

    public function addBodyRow(Table &$objTable): void
    {
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
        $strCr = $this->rpgMonster->getFormatCr();

        // Le type de monstre
        $strType = $this->rpgMonster->getStrType();

        // La taille
        $strSize = SizeHelper::toLabelFr($this->rpgMonster->getField(Field::MSTSIZE));

        // La CA
        $strCA = $this->rpgMonster->getField(Field::SCORECA);

        // Les HP
        $strHP = $this->rpgMonster->getField(Field::SCOREHP);

        // L'alignement
        $objAlignement = $this->rpgMonster->getAlignement();
        $strAlignement = $objAlignement->getStrAlignement();

        // Légendaire ?
        $strLegendaire = $this->rpgMonster->getField(Field::LEGENDARY)==1 ? 'Légendaire' : '';

        // Habitat
        $strHabitat = $this->rpgMonster->getField(Field::HABITAT);

        // Référence
        $objReference = $this->rpgMonster->getReference();
        $strReference = $objReference->getField(Field::NAME);

        $objTable->addBodyRow()
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
            ;
    }
    
    public function getMonsterCard(): string
    {
        $objsTrait = $this->rpgMonster->getTraits();
        $objsActions = $this->rpgMonster->getActions();
        $objsBonusActions = $this->rpgMonster->getBonusActions();
    
        $attributes = [
            $this->rpgMonster->getStrName(),
            $this->rpgMonster->getSizeTypeAndAlignement(),
            $this->rpgMonster->getStrExtra(Field::SCORECA),
            $this->rpgMonster->getStrInitiative(),
            $this->rpgMonster->getStrExtra(Field::SCOREHP),
            $this->rpgMonster->getStrVitesse(),
            $this->rpgMonster->getStringScore('str'),
            $this->rpgMonster->getStringScore('dex'),
            $this->rpgMonster->getStringScore('con'),
            $this->rpgMonster->getStringScore('int'),
            $this->rpgMonster->getStringScore('wis'),
            $this->rpgMonster->getStringScore('cha'),
            $this->getSkillsToCR(),
            $objsTrait->isEmpty() ? ' d-none' : '', // d-none si pas de Traits
            $this->getSpecialAbilitiesList($objsTrait), // Liste des traits
            $objsActions->isEmpty() ? ' d-none' : '', // d-none si pas d'Actions
            $this->getSpecialAbilitiesList($objsActions), // Liste des actions
            $objsBonusActions->isEmpty() ? ' d-none' : '', // d-none si pas de Bonus actions
            $this->getSpecialAbilitiesList($objsBonusActions), // Liste des Bonus actions
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

    private function getResistances(string $type, string $label, string $tag):string
    {
        $str = '';
        //////////////////////////////////////////////////////////////
        // Gestion des vulnérabilités, des résistances et des immunités du monstre
        $objs = $this->rpgMonster->getResistances($type);
        $resistances = $this->rpgMonster->getExtra($tag);
        if (!$objs->isEmpty() || $resistances!='') {
            $str .= '<div class="col-12"><strong>'.$label.'</strong> ';
            $comma = false;
            $objs->rewind();
            while ($objs->valid()) {
                if ($comma) {
                    $str .= ', ';
                }
                $obj = $objs->current();
                $str .= $obj->getTypeDamage()->getField(Field::NAME);
                $comma = true;
                $objs->next();
            }
            if ($resistances!='') {
                $str .= ($comma ? ', ' : '').$resistances;
            }
            $str .= '</div>';
        }
        //////////////////////////////////////////////////////////////
        return $str;
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
                $str .= $obj->getLanguage()->getField(Field::NAME);
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
        $extra = $this->rpgMonster->getExtra('pb');
        
        $str .= '<div class="col-12"><strong>FP</strong> '.$this->rpgMonster->getFormatCr();
        $str .= ' (PX '.$this->rpgMonster->getTotalXp().' ;';
        $str .= ' BM ' . ($bm==0 ? '' : '+'.$bm) . $extra.')</div>';
        //////////////////////////////////////////////////////////////
        
        return $str;
    }
    
    private function getSpecialAbilitiesList(Collection $objs): string
    {
        $str = '';
        $objs->rewind();
        while ($objs->valid()) {
            $obj = $objs->current();
            $str .= $obj->getController()->getFormatString();
            $objs->next();
        }
        return $str;
    }
    
}