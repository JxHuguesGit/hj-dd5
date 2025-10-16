<?php
namespace src\Controller;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Constant\Template;
use src\Entity\RpgFeat as EntityRpgFeat;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgFeat as RepositoryRpgFeat;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\Utils;
use WP_Post;

class RpgFeat extends Utilities
{
    protected EntityRpgFeat $rpgFeat;

    public function __construct()
    {
        parent::__construct();

        $this->title = Language::LG_FEATS;
    }
    
    public static function getTable(array $params): Table
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgFeat($queryBuilder, $queryExecutor);
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
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_FEATS])
            ->addHeaderCell([Constant::CST_CONTENT=>Language::LG_CATEGORY]);
        
        if ($rpgFeats->valid()) {
            $objTable->addBodyRows($rpgFeats, 2);
        }
        return $objTable;
    }

    public function addBodyRow(Table &$objTable): void
    {
        $strName = $this->rpgFeat->getField(Field::NAME);
        $objWpPost = $this->rpgFeat->getWpPost();
        if ($objWpPost instanceof WP_Post) {
            $strName = '<span class="modal-tooltip" data-modal="feat" data-postid="'.$this->rpgFeat->getField(Field::POSTID).'">'.$strName.' <span class="fa fa-search"></span></span>';
        } else {
            $strName .= ' <i class="fa-solid fa-info-circle float-end" data-modal="feat" data-postid="|'.$this->rpgFeat->getField(Field::ID).'"></i>';
        }
        $strFeatType = $this->rpgFeat->getFeatType()->getField(Field::NAME);

        $objTable->addBodyRow()
            ->addBodyCell([Constant::CST_CONTENT=>$strName])
            ->addBodyCell([Constant::CST_CONTENT=>$strFeatType]);
    }
    
    public function getCard(mixed $objWpPost): string
    {
        if ($objWpPost instanceof WP_Post) {
            $attributes = [
                $objWpPost->post_title,
                Html::shortcodes($objWpPost->post_content)
            ];
        } else {
            $queryBuilder  = new QueryBuilder();
            $queryExecutor = new QueryExecutor();
            $objDao = new RepositoryRpgFeat($queryBuilder, $queryExecutor);
            $objRpgFeat = $objDao->find(mb_substr($objWpPost, 1));
            if ($objRpgFeat==null) {
                $attributes = ['Erreur', "L'identifiant passé en paramètre [$objWpPost] ne correspond à aucun don en base"];
            } else {
                // On teste si la fiche français est accessible :
                $url = 'https://www.aidedd.org/feat/fr/'.sanitize_title(strtolower($objRpgFeat->getField(Field::NAME)));
                $content = file_get_contents($url);

                // Puis en anglais
                $url = 'https://www.aidedd.org/feat/'.sanitize_title(strtolower($objRpgFeat->getField(Field::NAME)));
                $content .= file_get_contents($url);
                
                // On va se retrouver avec les deux contenus, mais on s'en fout.
                $attributes = [
                    $objRpgFeat->getField(Field::NAME),
                    $content
                ];
            }
        }
           return $this->getRender(Template::FEAT_CARD, $attributes);
    }
}
