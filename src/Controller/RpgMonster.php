<?php
namespace src\Controller;

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
        $paginate = [
            Constant::PAGE_OBJS      => $objsMonstre,
            Constant::CST_CURPAGE    => $params[Constant::CST_CURPAGE] ?? 1,
            Constant::PAGE_NBPERPAGE => $params[Constant::PAGE_NBPERPAGE] ?? 20
        ];
        
        $objTable = new Table();
        $objTable->setTable([Constant::CST_CLASS=>'table-sm table-striped mt-5'])
            ->setPaginate($paginate)
            ->addHeader([Constant::CST_CLASS=>'table-dark text-center'])
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
        // Le monstre est-il complet ? Et a-t-il une traduction française ?
        // On pourrait rajouter : et est-il complet en français ?
        if ($this->rpgMonster->getField(Field::INCOMPLET)==0 && $this->rpgMonster->getField(Field::FRTAG)!='non') {
            $handle = fopen('http://localhost/wp-content/plugins/hj-dd5/assets/aidedd/'.$this->rpgMonster->getField(Field::UKTAG).'.html', 'r');
            if ($handle===false) {
                $strName .= ' <i class="fa-solid fa-download float-end" data-source="aidedd" data-uktag="'.$this->rpgMonster->getField(Field::UKTAG).'"></i>';
            }
        }
        $strName .= ' <i class="fa-solid fa-info-circle float-end" data-modal="monster" data-uktag="'.$this->rpgMonster->getField(Field::UKTAG).'"></i>';

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
    
        $attributes = [
            $this->rpgMonster->getField(Field::NAME),
            $this->rpgMonster->getSizeTypeAndAlignement(),
            $this->rpgMonster->getStrExtra(Field::SCORECA),
            $this->rpgMonster->getStrInitiative(),
            $this->rpgMonster->getStrExtra(Field::SCOREHP),
            $this->rpgMonster->getStrVitesse(),
            '', // Force
            '', // Dextérité
            '', // Constitution
            '', // Intelligence
            '', // Sagesse
            '', // Charisme
            $this->getSkillsToCR(),
            '', // d-none si pas de Traits
            $this->getTraitsList(), // Liste des traits
            '', // d-none si pas d'Actions
            $this->getActionsList(), // Liste des actions
            '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
        ];
        $content = $this->getRender(Template::MONSTER_CARD, $attributes);
        return $content;
    }

    private function getActionsList(): string
    {
        $str  = "<p><strong><em>Multiattack</em></strong>. The spirit makes a number of attacks equal to half this spell's level (round down).</p>";
        $str .= "<p><strong><em>Claw (Slaad Only)</em></strong>. <em>Melee Attack Roll</em>: Bonus equals your spell attack modifier, reach 5 ft. <em>Hit</em>: 1d10 + 3 + the spell's level Slashing damage, and the target can't regain Hit Points until the start of the spirit's next turn.</p>";
        $str .= "<p><strong><em>Eye Ray (Beholderkin Only)</em></strong>. <em>Ranged Attack Roll</em>: Bonus equals your spell attack modifier, range 150 ft. <em>Hit</em>: 1d8 + 3 + the spell's level Psychic damage.</p><p><strong><em>Psychic Slam (Mind Flayer Only)</em></strong>. <em>Melee Attack Roll</em>: Bonus equals your spell attack modifier, reach 5 ft. <em>Hit</em>: 1d8 + 3 + the spell's level Psychic damage.</p>";
        return $str;
    }
    
    private function getTraitsList(): string
    {
        $str  = "<p><strong><em>Regeneration (Slaad Only)</em></strong>. The spirit regains 5 Hit Points at the start of its turn if it has at least 1 Hit Point.</p>";
        $str .= "<p><strong><em>Whispering Aura (Mind Flayer Only)</em></strong>. At the start of each of the spirit's turns, the spirit emits psionic energy if it doesn't have the Incapacitated condition. <em>Wisdom Saving Throw</em>: DC equals your spell save DC, each creature (other than you) within 5 feet of the spirit. <em>Failure</em>: 2d6 Psychic damage.</p>";
        return $str;

    }
    private function getSkillsToCR(): string
    {
        $str  = '<div class="col-12"><strong>Immunités</strong> TODO</div>';
        $str .= '<div class="col-12"><strong>Sens</strong> TODO, Passive Perception ??</div>';
        $str .= '<div class="col-12"><strong>Langues</strong> TODO</div>';
        $str .= '<div class="col-12"><strong>CR</strong> ?? (XP ??; PB ??)</div>';
        return $str;
    }
}
