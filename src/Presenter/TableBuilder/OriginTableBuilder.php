<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Origin as DomainOrigin;
use src\Presenter\TableBuilder\TableBuilderInterface;
use src\Service\OriginService;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class OriginTableBuilder implements TableBuilderInterface
{
    public function __construct(
        private OriginService $originService
    ) {}
    
    public function build(iterable $origins, array $params = []): Table
    {
        $table = new Table();
        $table->setTable([
                Constant::CST_CLASS => implode(
                    ' ',
                    [Bootstrap::CSS_TABLE_SM, Bootstrap::CSS_TABLE_STRIPED, $params[Bootstrap::CSS_WITH_MRGNTOP] ? Bootstrap::CSS_MT5 : '']
                )])
            ->addHeader([Constant::CST_CLASS => implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow();
        $this->addHeaders($table);

        foreach ($origins as $origin) {
            /** @var DomainOrigin $origin */
            $this->addOriginRow($table, $origin);
        }

        return $table;
    }

    private function addHeaders(Table $table): void
    {
        $headerLabels = [
            Language::LG_ORIGINS,
            Language::LG_ABILITIES,
            Language::LG_ORIGIN_FEAT,
            Language::LG_SKILLS,
            Language::LG_TOOLS,
        ];
        foreach ($headerLabels as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }
    }

    private function addOriginRow(Table $table, DomainOrigin $origin): void
    {
        /////////////////////////////////////////////////////////////////////
        // Le nom
        $strUrl = Html::getLink(
            $origin->name,
            UrlGenerator::origin($origin->getSlug()),
            Bootstrap::CSS_TEXT_DARK
        );
        // La liste des caractéristiques
        $strAbilities = $this->getAbilitiesString($origin);
        // La liste des compétences
        $strSkills = $this->getSkillsString($origin);
        // Le don d'origine rattaché
        $originUrl = $this->getFeatLink($origin);
        // L'outil rattaché
        $toolUrl = $this->getToolLink($origin);
    
        $table->addBodyRow([])
            ->addBodyCell([Constant::CST_CONTENT => $strUrl])
            ->addBodyCell([Constant::CST_CONTENT => $strAbilities])
            ->addBodyCell([Constant::CST_CONTENT => $originUrl])
            ->addBodyCell([Constant::CST_CONTENT => $strSkills])
            ->addBodyCell([Constant::CST_CONTENT => $toolUrl]);
    }

    private function getAbilitiesString(DomainOrigin $origin): string
    {
        // La liste des caractéristiques
        $parts = [];
        $abilities = $this->originService->getAbilities($origin);
        foreach ($abilities as $ability) {
            $parts[] = $ability->name;
        }
        return implode(', ', $parts);
    }

    private function getSkillsString(DomainOrigin $origin): string
    {
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
        return implode(', ', $parts);
    }

    private function getFeatLink(DomainOrigin $origin): string
    {
        $feat = $this->originService->getFeat($origin);
        $strOriginFeat = $feat?->name ?? '-';
        return Html::getLink(
            $strOriginFeat,
            UrlGenerator::feat($feat->getSlug()),
            Bootstrap::CSS_TEXT_DARK
        );
    }

    private function getToolLink(DomainOrigin $origin): string
    {
        $tool = $this->originService->getTool($origin);
        $strTool = $tool?->name ?? '-';
        return Html::getLink(
            $strTool,
            UrlGenerator::item($tool?->getSlug() ?? ''),
            Bootstrap::CSS_TEXT_DARK
        );
    }

}
