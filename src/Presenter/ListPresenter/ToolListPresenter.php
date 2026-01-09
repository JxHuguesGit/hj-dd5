<?php
namespace src\Presenter\ListPresenter;

use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Tool as DomainTool;

class ToolListPresenter
{
    /**
     * Transforme une liste d'outils en tableau prêt pour le Renderer.
     * Groupé par type.
     */
    public function present(iterable $tools): array
    {
        $grouped = [];
        foreach ($tools as $tool) {
            /** @var DomainTool $tool */
            $grouped[$tool->parentId][] = $tool;
        }

        $typesLabel = [
            1 => Language::LG_TOOL_DIVERS,
            2 => Language::LG_TOOL_GAMES,
            3 => Language::LG_TOOL_MUSIC,
            4 => Language::LG_TOOL_TOOLS,
        ];

        $result = [];
        foreach ($grouped as $typeId => $toolsByType) {
            $result[] = [
                Constant::CST_TYPELABEL => $typesLabel[$typeId],
                Constant::CST_TOOLS => $toolsByType
            ];
        }

        return [Constant::CST_ITEMS=>$result];
    }
}
