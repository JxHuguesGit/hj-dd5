<?php
namespace src\Presenter\ListPresenter;

use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Tool as DomainTool;
use src\Presenter\ViewModel\ToolGroup;
use src\Presenter\ViewModel\ToolRow;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

final class ToolListPresenter
{
    public function present(iterable $tools): array
    {
        $grouped = [];
        foreach ($tools as $tool) {
            /** @var DomainTool $tool */
            $grouped[$tool->parentId][] = $this->buildRow($tool);
        }

        $types = self::getToolTypes();
        $result = [];
        foreach ($grouped as $typeId => $rows) {
            $result[] = new ToolGroup(
                label: $types[$typeId][Constant::CST_LABEL] ?? '',
                slug: $types[$typeId][Constant::CST_SLUG] ?? '',
                rows: $rows
            );
        }

        return [Constant::CST_ITEMS => $result];
    }

    private function buildRow(DomainTool $tool): ToolRow
    {
        return new ToolRow(
            name: $tool->name,
            url: UrlGenerator::item($tool->slug),
            weight: Utils::getStrWeight($tool->weight),
            price: Utils::getStrPrice($tool->goldPrice)
        );
    }

    private static function getToolTypes(): array
    {
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
