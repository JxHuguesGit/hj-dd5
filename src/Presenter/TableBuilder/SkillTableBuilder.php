<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Presenter\ViewModel\SkillGroup;
use src\Presenter\ViewModel\SkillLink;
use src\Presenter\ViewModel\SkillRow;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class SkillTableBuilder extends AbstractTableBuilder
{

    public function __construct(
        private bool $isAdmin = false
    ) {}

    public function build(mixed $groups, array $params = []): Table
    {
        $headers = [
            [C::LABEL => L::NAMES, C::CSSCLASS => B::COL_2],
            [C::LABEL => L::DESCRIPTION, C::CSSCLASS => B::COL_7],
            [C::LABEL => 'Sous-compétences', C::CSSCLASS => B::COL_3],
        ];
        if ($this->isAdmin) {
            $headers[] = [
                C::LABEL => Html::getLink(
                    Html::getIcon(I::PLUS),
                    UrlGenerator::admin(C::ONG_COMPENDIUM, C::FEATS, '', C::NEW),
                    B::TEXT_WHITE
                )
            ];
        }
        $params[C::ID]     = 'skillTable';
        $params[C::TARGET] = 'skillFilter';

        $table   = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($groups as $group) {
            /** @var SkillGroup $group */
            $this->buildGroups($table, $headers, $group);
        }

        return $table;
    }

    private function buildGroups(Table $table, array $headers, SkillGroup $group): void
    {
        $this->addGroupRow($table, $group->label, count($headers));

        foreach ($group->rows as $row) {
            /** @var SkillRow $row */
            $this->buildRow($table, $row);
        }
    }

    private function buildRow(Table $table, SkillRow $row): void
    {
        $table->addBodyRow([])
            ->addBodyCell([
                C::CONTENT => Html::getLink($row->name, $row->url, B::TEXT_DARK),
                C::ATTRIBUTES => [C::CSSCLASS => B::BORDER_END]
            ])
            ->addBodyCell([
                C::CONTENT => $row->description,
                C::ATTRIBUTES => [C::CSSCLASS => B::BORDER_END]
            ])
            ->addBodyCell([
                C::CONTENT => $this->renderLinks($row->subSkills)
            ]);
        if ($this->isAdmin) {
            $table->addBodyCell([
                C::CONTENT => Html::getLink(
                    Html::getIcon(I::EDIT),
                    UrlGenerator::admin(C::ONG_COMPENDIUM, C::SKILLS, $row->id, C::EDIT),
                    B::TEXT_DARK
                ),
                C::ATTRIBUTES => [C::CSSCLASS => B::BORDER_START]
            ]);
        }
    }

    private function renderLinks(array $links): string
    {
        return implode(
            '<br>',
            array_map(
                fn(SkillLink $link) => Html::getLink(
                    $link->name,
                    $link->url,
                    B::TEXT_DARK
                ),
                $links
            )
        );
    }
}
