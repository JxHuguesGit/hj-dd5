<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Skill as DomainSkill;
use src\Presenter\TableBuilder\TableBuilderInterface;
use src\Service\SkillService;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class SkillTableBuilder implements TableBuilderInterface
{
    public function __construct(
        private SkillService $skillService
    ) {}

    public function build(iterable $skills, array $params=[]): Table
    {
        $withMarginTop = $params[Bootstrap::CSS_WITH_MRGNTOP] ?? true;
    
        $table = new Table();
        $table->setTable([Constant::CST_CLASS => implode(' ', [
                Bootstrap::CSS_TABLE_SM,
                Bootstrap::CSS_TABLE_STRIPED,
                $withMarginTop ? Bootstrap::CSS_MT5 : ''
            ])])
            ->addHeader([Constant::CST_CLASS => implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_SKILLS])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_DESCRIPTION])
            ->addHeaderCell([Constant::CST_CONTENT => 'Sous-compétences'])
            ;

        foreach ($skills as $group) {
            // Ligne de rupture
            $table->addBodyRow([Constant::CST_CLASS => Bootstrap::CSS_ROW_DARK_STRIPED])
                ->addBodyCell([
                    Constant::CST_CONTENT => $group[Constant::CST_TYPELABEL],
                    Constant::CST_ATTRIBUTES => [
                        Constant::CST_COLSPAN => 6,
                        Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC
                    ]
                ]);

            // Armures de ce type
            foreach ($group[Constant::SKILLS] as $skill) {
                $strLink = Html::getLink(
                    $skill->name,
                    UrlGenerator::skill($skill->getSlug()),
                    Bootstrap::CSS_TEXT_DARK
                );
            
                // La liste des sous-compétences
                $parts = [];
                $subSkills = $this->skillService->getSubSkills($skill);
                foreach ($subSkills as $subSkill) {
                    $subSkillUrl = Html::getLink(
                        $subSkill->name,
                        UrlGenerator::skill($subSkill->getSlug()),
                        Bootstrap::CSS_TEXT_DARK
                    );
                    $parts[] = $subSkillUrl;
                }
                $strSubSkills = implode('<br>', $parts);

                /** @var DomainSkill $skill */
                $table->addBodyRow([])
                    ->addBodyCell([Constant::CST_CONTENT => $strLink])
                    ->addBodyCell([Constant::CST_CONTENT => $skill->description])
                    ->addBodyCell([Constant::CST_CONTENT => $strSubSkills])
                ;
            }
        }

        return $table;
    }
}
