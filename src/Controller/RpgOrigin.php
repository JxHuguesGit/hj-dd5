<?php
namespace src\Controller;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Entity\RpgOrigin as EntityRpgOrigin;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgAbility as RepositoryRpgAbility;
use src\Repository\RpgFeat as RepositoryRpgFeat;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;
use src\Repository\RpgOriginAbility as RepositoryRpgOriginAbility;
use src\Repository\RpgOriginSkill as RepositoryRpgOriginSkill;
use src\Repository\RpgSkill as RepositoryRpgSkill;
use src\Repository\RpgTool as RepositoryRpgTool;
use src\Service\RpgAbilityQueryService;
use src\Service\RpgOriginQueryService;
use src\Service\RpgOriginService;
use src\Service\RpgSkillQueryService;
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
        $originQueryService = new RpgOriginQueryService(
            new RepositoryRpgOrigin(new QueryBuilder(), new QueryExecutor())
        );
        $origins = $originQueryService->getAllOrigins([Field::NAME=>Constant::CST_ASC]);
        $objTable = static::getTable($origins, $params);
        return $objTable?->display();
    }

    public static function getTable(iterable $origins, array $params=[]): Table
    {
        $objTable = new Table();
        $objTable->setTable([Constant::CST_CLASS => implode(' ', [Bootstrap::CSS_TABLE_SM, Bootstrap::CSS_TABLE_STRIPED, $params['withMarginTop'] ? Bootstrap::CSS_MT5 : ''])])
            ->addHeader([Constant::CST_CLASS => implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_ORIGINS])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_ABILITIES])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_ORIGIN_FEAT])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_SKILLS])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_TOOLS]);

        foreach ($origins as $origin) {
            /////////////////////////////////////////////////////////////////////
            // Le nom
            $strName = $origin->name;

            // La liste des caractéristiques
            $parts = [];
            $originService = new RpgOriginService(
                new RepositoryRpgFeat(new QueryBuilder(), new QueryExecutor()),
                new RepositoryRpgOriginSkill(new QueryBuilder(), new QueryExecutor()),
                new RepositoryRpgOriginAbility(new QueryBuilder(), new QueryExecutor()),
                new RpgSkillQueryService(new RepositoryRpgSkill(new QueryBuilder(), new QueryExecutor())),
                new RpgAbilityQueryService(new RepositoryRpgAbility(new QueryBuilder(), new QueryExecutor())),
            );
            $abilities = $originService->getAbilities($origin);
            foreach ($abilities as $ability) {
                $parts[] = $ability->name;
            }
            $strAbilities = implode(', ', $parts);

            // Le don d'origine rattaché
            $feat = $originService->getFeat($origin);
            $strOriginFeat = $feat?->name ?? '-';

            // La liste des compétences
            $parts = [];
            $skills = $originService->getSkills($origin);
            foreach ($skills as $skill) {
                $skillUrl = $skill->name;
                $parts[] = $skillUrl;
            }
            $strSkills = implode(', ', $parts);

            //$origin->getTool()?->name ?? '';
            $strTool = '';
        
        
            $objTable->addBodyRow([])
                ->addBodyCell([Constant::CST_CONTENT => $strName])
                ->addBodyCell([Constant::CST_CONTENT => $strAbilities])
                ->addBodyCell([Constant::CST_CONTENT => $strOriginFeat])
                ->addBodyCell([Constant::CST_CONTENT => $strSkills])
                ->addBodyCell([Constant::CST_CONTENT => $strTool]);
        }

        return $objTable;
    }

    public function addBodyRow(Table &$objTable): void
    {
        /////////////////////////////////////////////////////////////////////
        // Le nom
        $strName = $this->rpgOrigin->getName();
        
        // La liste des caractéristiques
        $parts = [];
        $abilities = $this->rpgOrigin->getOriginAbilities();
        foreach ($abilities as $ability) {
            $parts[] = $ability->getAbility()->getName();
        }
        $strAbilities = implode(', ', $parts);
        
        // Le don d'origine rattaché
        $strOriginFeat = $this->rpgOrigin->getOriginFeat()->getName();
        
        $parts = [];
        $skills = $this->rpgOrigin->getOriginSkills();
        foreach ($skills as $skill) {
            $parts[] = $skill->getSkill()->getName();
        }
        $strSkills = implode(', ', $parts);

        // L'outil rattaché
        $strTool = $this->rpgOrigin->getOriginTool()->getName();
                
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
        return '<div class="form-check">
            <input class="ajaxAction" data-trigger="click" data-type="origin" type="radio" name="characterOriginId" value="'.$id.'" id="origin'.$id.'"'.($checked?' checked':'').'>
                <label class="form-check-label" for="origin'.$id.'">'.$name.'</label>
            </div>';
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
        $returned .= '<strong>Matériel</strong> : WIP<br>';
        
        return $returned;
    }
}
