<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\AoeConfig;
use src\Constant\Constant as C;
use src\Utils\Html;

final class AoeContentBuilder
{
    public function build(): string
    {
        $content = '';

        for ($y = AoeConfig::MIN_Y; $y <= AoeConfig::MAX_Y; $y++) {
            for ($x = AoeConfig::MIN_X; $x <= AoeConfig::MAX_X; $x++) {
                $content .= Html::getDiv('', [
                    C::CSSCLASS => 'cell',
                    C::DATA     => [
                        'x' => $x,
                        'y' => $y,
                    ],
                ]);
            }
        }

        return Html::getDiv($content, [
            C::ID => 'grid',
            C::DATA => [
                'min-x' => AoeConfig::MIN_X,
                'max-x' => AoeConfig::MAX_X,
                'min-y' => AoeConfig::MIN_Y,
                'max-y' => AoeConfig::MAX_Y,
            ],
            'style' => '--grid-size: ' . AoeConfig::getWidth() . ';',
        ]);
    }

    public function buildHeader(): string
    {
        return '';
    }
}
