<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Constant as C;
use src\Utils\Html;

final class AoeContentBuilder
{
    public function build(): string
    {
        $content = '';
        for ($y=-24 ; $y<=24 ; $y++) {
            for ($x=-24 ; $x<=24 ; $x++ ) {
                $content .= Html::getDiv('',[
                    C::CSSCLASS => 'cell',
                    C::DATA     => [
                        'x' => $x,
                        'y' => $y,
                    ]
                ]);
            }
        }
        return Html::getDiv($content, [C::ID => 'grid']);
    }

    public function buildHeader(): string
    {
        return '';
    }
}
