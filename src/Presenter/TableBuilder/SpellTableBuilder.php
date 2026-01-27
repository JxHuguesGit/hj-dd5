<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Icon;
use src\Presenter\ViewModel\SpellRow;
use src\Utils\Table;
use src\Utils\Html;
use src\Constant\Language;
use src\Enum\ClassEnum;

class SpellTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $rows, array $params = []): Table
    {
        $params[Constant::CST_ID] = 'spellTable';
        $table = $this->createTable(8, $params);

        $headers = [
            [Constant::CST_LABEL=>Language::LG_SPELLS],
            [Constant::CST_LABEL=>Language::LG_LEVEL, 'filter'=>true],
            [Constant::CST_LABEL=>Language::LG_SCHOOL, 'filter'=>true],
            [Constant::CST_LABEL=>Language::LG_CLASSES, 'filter'=>true],
            [Constant::CST_LABEL=>'TI', 'abbr'=>Language::LG_INCTIME],
            [Constant::CST_LABEL=>Language::LG_RANGE],
            [Constant::CST_LABEL=>Language::LG_DURATION],
            [Constant::CST_LABEL=>'V,S,M', 'abbr'=>Language::LG_COMPONENTS],
            /*
            [Constant::CST_LABEL=>'C', 'abbr'=>'Concentration'],
            [Constant::CST_LABEL=>'R', 'abbr'=>'Rituel']
            */
        ];
        foreach ($headers as $data) {
            if (isset($data['abbr'])) {
                $strContent = Html::getBalise('abbr', $data[Constant::CST_LABEL], [Constant::CST_TITLE=>$data['abbr']]);
            } else {
                $strContent = $data[Constant::CST_LABEL];
            }

            if ($data['filter'] ?? false) {
                $strContent = Html::getDiv(
                    $strContent . ' '.Html::getIcon(
                        Icon::IFITLER,
                        Icon::SOLID,
                        [
                            Constant::CST_CLASS => 'modal-tooltip ajaxAction',
                            Constant::CST_DATA  => [
                                Constant::CST_TRIGGER => Constant::CST_CLICK,
                                Constant::CST_ACTION  => Constant::CST_OPENMODAL,
                                Constant::CST_TARGET  => 'spellFilter',
                            ]
                        ]
                    ),
                    [Constant::CST_CLASS => Bootstrap::CSS_TEXT_NOWRAP]
                );
            }
            $table->addHeaderCell([Constant::CST_CONTENT => $strContent]);
        }

        foreach ($rows as $row) {
            /** @var SpellRow $row */
            $table->addBodyRow([])
                ->addBodyCell([Constant::CST_CONTENT => Html::getLink($row->name, $row->url, Bootstrap::CSS_TEXT_DARK)])
                ->addBodyCell([
                    Constant::CST_CONTENT => $row->niveau,
                    Constant::CST_ATTRIBUTES=>[Constant::CST_CLASS => Bootstrap::CSS_TEXT_CENTER]
                ])
                ->addBodyCell([Constant::CST_CONTENT => $row->ecole])
                ->addBodyCell([Constant::CST_CONTENT => $this->formatClasses($row->classes, false)])
                ->addBodyCell([Constant::CST_CONTENT => $this->formatIncantation($row->tpsInc, $row->rituel)])
                ->addBodyCell([Constant::CST_CONTENT => $this->formatPortee($row->portee)])
                ->addBodyCell([Constant::CST_CONTENT => $this->formatDuree($row->duree, $row->concentration)])
                ->addBodyCell([Constant::CST_CONTENT => $this->formatComposantes($row->composantes, $row->composanteMaterielle, false)])
                /*
                ->addBodyCell([Constant::CST_CONTENT => $row->concentration ? 'Concentration' : ''])
                ->addBodyCell([Constant::CST_CONTENT => $row->rituel ? 'Rituel' : ''])
                */
            ;
        }

        $table->addFooter([
            Constant::CST_CLASS => implode(' ', [
                Bootstrap::CSS_TABLE_DARK,
                Bootstrap::CSS_TEXT_CENTER
            ])
        ])
            ->addFootRow()
            ->addFootCell([
                Constant::CST_CONTENT=>'<div class="ajaxAction" data-trigger="click" data-action="loadMoreSpells" style="cursor:pointer;"><i class="fa-solid fa-circle-plus"></i></div>',
                Constant::CST_ATTRIBUTES=>[Constant::CST_COLSPAN=>8]
            ]);

        return $table;
    }

    private function formatComposantes(array $composantes, string $composanteMaterielle='', bool $detail=true): string
    {
        $str = implode(',', $composantes);
        if (in_array('M', $composantes)) {
            if ($detail) {
                $str .= ' ('.$composanteMaterielle.')';
            } else {
                $str = str_replace('M', '<abbr title="'.$composanteMaterielle.'">M</abbr>', $str);
            }
        }
        return $str;
    }

    private function formatDuree(string $value, bool $isConcentration, bool $detail=true): string
    {
        $prefix = ($isConcentration && $detail)
            ? "Concentration, jusqu'à "
            : '';

        return $prefix . $this->formatDureeConvertie($value);
    }

    private function formatDistance(string $value): string
    {
        $returned = (str_contains($value, 'km'))
            ? substr($value, 0, -2) . ' km'
            : substr($value, 0, -1) . ' m';

        return str_replace('.', ',', $returned);
    }
    
    private function formatPortee(string $value): string
    {
        return match ($value) {
            'vue', 'contact' => ucwords($value),
            'illim'   => 'Illimitée',
            'perso'   => 'Personnelle',
            'spec'    => 'Spéciale',
            default   => $this->formatDistance($value),
        };
    }

    private function formatClasses(array $value, bool $parenthesis=true): string
    {
        $classes = array_map(
            fn(string $value) => ClassEnum::from($value)->label(),
            $value
        );
        return $parenthesis ? '(' . implode(', ', $classes) . ')' : implode(', ', $classes);
    }

    private function formatIncantation(string $value, bool $isRituel): string
    {
        return $this->formatDureeConvertie($value). ($isRituel ? ' ou Rituel' : '');
    }

    private function formatDureeConvertie(string $value): string
    {
        if (str_contains($value, 'min')) {
            $returned = intval($value) . ' minute' . (intval($value) > 1 ? 's' : '');
        } elseif (str_contains($value, 'rd')) {
            $returned = intval($value) . ' round' . (intval($value) > 1 ? 's' : '');
        } elseif (str_contains($value, 'hr')) {
            $returned = intval($value) . ' heure' . (intval($value) > 1 ? 's' : '');
        } elseif (str_contains($value, 'jr')) {
            $returned = intval($value) . ' jour' . (intval($value) > 1 ? 's' : '');
        } else {
            $returned = match ($value) {
                'diss'   => "Jusqu'à dissipation",
                'inst'   => 'Instantanée',
                'spec'   => 'Spéciale',
                'bonus'  => 'Action Bonus',
                'action' => 'Action',
                'reaction' => 'Réaction',
                default  => $value,
            };
                /*
    Jusqu'à 1 minute
    Jusqu'à 1 heure
    Jusqu'à 8 heures
    Dissipation/Déclenchement
                */
        }
        return $returned;
    }
}
