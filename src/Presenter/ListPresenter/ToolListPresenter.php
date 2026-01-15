<?php
namespace src\Presenter\ListPresenter;

use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Tool as DomainTool;
use src\Presenter\ViewModel\ToolGroup;

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

        $types = self::getToolTypes();

        $result = [];
        foreach ($grouped as $typeId => $toolsByType) {
            $result[] = new ToolGroup(
                $types[$typeId][Constant::CST_LABEL] ?? '',
                $types[$typeId][Constant::CST_SLUG] ?? '',
                $toolsByType
            );
        }

        return [Constant::CST_ITEMS=>$result];
    }
    private static function getToolTypes(): array {
        return [
            DomainTool::TYPE_DIVERS => [
                Constant::CST_SLUG => Constant::DIVERS,
                Constant::CST_LABEL => Language::LG_TOOL_DIVERS,
            ],
            DomainTool::TYPE_GAMES => [
                Constant::CST_SLUG => Constant::GAMES,
                Constant::CST_LABEL => Language::LG_TOOL_GAMES,
            ],
            DomainTool::TYPE_MUSIC => [
                Constant::CST_SLUG => Constant::MUSIC,
                Constant::CST_LABEL => Language::LG_TOOL_MUSIC,
            ],
            DomainTool::TYPE_TOOL => [
                Constant::CST_SLUG => Constant::TOOLS,
                Constant::CST_LABEL => Language::LG_TOOL_TOOLS,
            ],
        ];
     }
}
