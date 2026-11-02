<?php

namespace src\Action\Ajax;

use src\Constant\Field as F;
use src\Constant\Template as T;
use src\Factory\ReaderFactory;
use src\Renderer\TemplateRenderer;
use src\Utils\Session;

final class ShowModalMonsterAction
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private TemplateRenderer $renderer
    ) {}

    public function execute(): array
    {
        $monsterId = Session::fromPost(F::MONSTERID);
        $option    = Session::fromPost('option');

        $monster = $this->readerFactory->monster()->monsterById($monsterId);
        $monsterName = $monster->identity()->getFrenchName();
        if ($monsterName === '') {
            $monsterName = $monster->identity()->getName();
        }

        $libelleTypeAlignement = $monster->type()->getName();
        $subType = $monster->subType()->getName();
        if ($subType != '') {
            $libelleTypeAlignement .= ' (' . $subType . '), ';
        }
        //$libelleTypeAlignement .= $monster->alignment()->getName();

        $panelContent = $this->renderer->render(
            T::MODAL_MONSTER,
            [
                $monsterName,
                $libelleTypeAlignement, // Gargantuan Dragon (Metallic), Lawful Good
            ]
        );

        return [
            'modal' => $panelContent
        ];
    }
}
