<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\RpgMonster as EntityRpgMonster;
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

    public function getContentPage(): string
    {
        return 'WIP RpgMonster::getContentPage';
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
        // Le nom
        // On pourrait envisager de mettre un lien ou une popup pour afficher le monstre.
        $strName = $this->rpgMonster->getField(Field::NAME);
          $strName = '<span class="modal-tooltip" data-modal="monster" data-uktag="id-'.$this->rpgMonster->getField(Field::ID).'">'.$strName.' <span class="fa fa-search"></span></span>';
        
        // Le monstre est-il complet ? Et a-t-il une traduction française ?
        // On pourrait rajouter : et est-il complet en français ?
        $urlDistante = 'https://www.aidedd.org/monster/';
        $urlLocale = '../wp-content/plugins/hj-dd5/assets/aidedd/';
        $ukTag = $this->rpgMonster->getField(Field::UKTAG);
        $handleUk = fopen($urlLocale.$ukTag.'.html', 'r');
        if ($handleUk===false) {
            $content = file_get_contents($urlDistante.$ukTag);
            $urlDestination = '../wp-content/plugins/hj-dd5/assets/aidedd/'.$ukTag.'.html';
            file_put_contents($urlDestination, $content);
        }

        $strName .= '<i class="float-end" data-modal="monster" data-uktag="'.$ukTag.'">🇬🇧</i>';

        $frTag = $this->rpgMonster->getField(Field::FRTAG);
        if ($frTag!='non') {
            $handleFr = fopen($urlLocale.$ukTag.'.html', 'r');
            if ($handleFr===false) {
                $content = file_get_contents($urlDistante.$frTag);
                $urlDestination = '../wp-content/plugins/hj-dd5/assets/aidedd/fr-'.$frTag.'.html';
                file_put_contents($urlDestination, $content);
            } else {
                $strName .= '<i class="float-end" data-modal="monster" data-uktag="fr-'.$frTag.'">🇫🇷</i>';
            }
        }

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
            '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
        ];
        return $this->getRender(Template::MONSTER_CARD, $attributes);
    }
    
    private function getSkillsToCR(): string
    {
        $str  = '';
        // Gestion des immunités du monstre
        $objs = $this->rpgMonster->getResistances('I');
        $immunities = $this->rpgMonster->getExtra('immunities');
        if (!$objs->isEmpty() && $immunities!='') {
            $str .= '<div class="col-12"><strong>Immunités</strong> ';
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
            if ($immunities!='') {
                $str .= ($comma ? ', ' : '').$immunities;
            }
            $str .= '</div>';
        }
        // Fin gestion des immunités du monstre

        $senses = $this->rpgMonster->getExtra('senses');
        if ($senses!='') {
            $str  .= '<div class="col-12"><strong>Sens</strong> '.$senses.'</div>';
        }
        $languages = $this->rpgMonster->getExtra('languages');
        if ($languages!='') {
            $str  .= '<div class="col-12"><strong>Langues</strong> '.$languages.'</div>';
        }
        $str .= '<div class="col-12"><strong>FP</strong> '.$this->rpgMonster->getFormatCr().' (PX '.$this->rpgMonster->getTotalXp().' ; PB '.$this->rpgMonster->getExtra('pb').')</div>';
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
