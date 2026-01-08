<?php
namespace src\Presenter;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Service\RpgOriginService;
use src\Utils\Html;
use src\Utils\Table;

class RpgOriginTableBuilder
{
    public function __construct(
        private RpgOriginService $originService
    ) {}
    
    public function build(iterable $origins, array $params = []): Table
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
            $strUrl = Html::getLink($strName, '/origine-'.$origin->getSlug(), Bootstrap::CSS_TEXT_DARK);
            
            // La liste des caractéristiques
            $parts = [];
            $abilities = $this->originService->getAbilities($origin);
            foreach ($abilities as $ability) {
                $parts[] = $ability->name;
            }
            $strAbilities = implode(', ', $parts);
            
            // La liste des compétences
            $parts = [];
            $skills = $this->originService->getSkills($origin);
            foreach ($skills as $skill) {
                $skillUrl = Html::getLink($skill->name, '/skill-'.$skill->slug, Bootstrap::CSS_TEXT_DARK);
                $parts[] = $skillUrl;
            }
            $strSkills = implode(', ', $parts);
            
            // Le don d'origine rattaché
            $feat = $this->originService->getFeat($origin);
            $strOriginFeat = $feat?->name ?? '-';
            $originUrl = Html::getLink($strOriginFeat, '/feat-'.$feat?->getSlug(), Bootstrap::CSS_TEXT_DARK);

            // L'outil rattaché
            $tool = null;//$this->originService->getTool($origin);
            $strTool = $tool?->getName() ?? '-';
            $toolUrl = Html::getLink($strTool, '/item-'.$tool?->getSlug(), Bootstrap::CSS_TEXT_DARK);
        
            $objTable->addBodyRow([])
                ->addBodyCell([Constant::CST_CONTENT => $strUrl])
                ->addBodyCell([Constant::CST_CONTENT => $strAbilities])
                ->addBodyCell([Constant::CST_CONTENT => $originUrl])
                ->addBodyCell([Constant::CST_CONTENT => $strSkills])
                ->addBodyCell([Constant::CST_CONTENT => $toolUrl]);
        }

        return $objTable;
    }
    
    // TODO à supprimer, éventuellement gérer la pagination avant
    /*

    public static function getTable(iterable $origins, array $params=[]): Table
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
        $objTable->setTable([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_SM, Bootstrap::CSS_TABLE_STRIPED, Bootstrap::CSS_MT5])])
            ->setPaginate($paginate)
            ->addHeader([Constant::CST_CLASS=>implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->setNbPerPage($refElementId, $nbPerPage)
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_ORIGINS])
            ->addHeaderCell([Constant::CST_CONTENT=>'Caractéristiques'])
            ->addHeaderCell([Constant::CST_CONTENT=>"Don d'origine"])
            ->addHeaderCell([Constant::CST_CONTENT=>'Compétences'])
            ->addHeaderCell([Constant::CST_CONTENT=>'Outils']);
        
        if ($rpgFeats->valid()) {
            $objTable->addBodyRows($rpgFeats, 5);
        }
        return $objTable;
    }
        */

}