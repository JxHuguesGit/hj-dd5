<?php
namespace src\Presenter;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Service\RpgOriginService;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class RpgOriginTableBuilder
{
    public function __construct(
        private RpgOriginService $originService
    ) {}
    
    public function build(iterable $origins, array $params = []): Table
    {
        $objTable = new Table();
        $objTable->setTable([
                Constant::CST_CLASS => implode(
                    ' ',
                    [Bootstrap::CSS_TABLE_SM, Bootstrap::CSS_TABLE_STRIPED, $params[Bootstrap::CSS_WITH_MRGNTOP] ? Bootstrap::CSS_MT5 : '']
                )])
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
            $strUrl = Html::getLink(
                $strName,
                UrlGenerator::origin($origin->getSlug()),
                Bootstrap::CSS_TEXT_DARK
            );
            
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
                $skillUrl = Html::getLink(
                    $skill->name,
                    UrlGenerator::skill($skill->slug),
                    Bootstrap::CSS_TEXT_DARK
                );
                $parts[] = $skillUrl;
            }
            $strSkills = implode(', ', $parts);
            
            // Le don d'origine rattaché
            $feat = $this->originService->getFeat($origin);
            $strOriginFeat = $feat?->name ?? '-';
            $originUrl = Html::getLink(
                $strOriginFeat,
                UrlGenerator::feat($feat->getSlug()),
                Bootstrap::CSS_TEXT_DARK
            );

            // L'outil rattaché
            $tool = null;//$this->originService->getTool($origin);
            $strTool = $tool?->getName() ?? '-';
            $toolUrl = Html::getLink(
                $strTool,
                UrlGenerator::item($tool?->getSlug() ?? ''),
                Bootstrap::CSS_TEXT_DARK
            );
        
            $objTable->addBodyRow([])
                ->addBodyCell([Constant::CST_CONTENT => $strUrl])
                ->addBodyCell([Constant::CST_CONTENT => $strAbilities])
                ->addBodyCell([Constant::CST_CONTENT => $originUrl])
                ->addBodyCell([Constant::CST_CONTENT => $strSkills])
                ->addBodyCell([Constant::CST_CONTENT => $toolUrl]);
        }

        return $objTable;
    }

}
