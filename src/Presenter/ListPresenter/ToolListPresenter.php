<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Entity\Tool;
use src\Presenter\ViewModel\ToolGroup;
use src\Presenter\ViewModel\ToolRow;
use src\Service\Reader\OriginReader;
use src\Utils\Html;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

final class ToolListPresenter
{
    public function __construct(
        private OriginReader $originReader
    ) {}

    public function present(iterable $tools): Collection
    {
        $grouped = [];
        foreach ($tools as $tool) {
            /** @var Tool $tool */
            $grouped[$tool->parentId][] = $this->buildRow($tool);
        }

        $types = self::getToolTypes();
        $collection = new Collection();
        foreach ($grouped as $typeId => $rows) {
            $collection->add(new ToolGroup(
                label: $types[$typeId][Constant::CST_LABEL] ?? '',
                slug: $types[$typeId][Constant::CST_SLUG] ?? '',
                rows: $rows
            ));
        }

        return $collection;
    }

    private function buildRow(Tool $tool): ToolRow
    {
        $originLabel = $this->resolveToolDetails($tool);

        return new ToolRow(
            name: $tool->name,
            url: UrlGenerator::item($tool->slug),
            originLabel: $originLabel,
            weight: Utils::getStrWeight($tool->weight),
            price: Utils::getStrPrice($tool->goldPrice)
        );
    }

    private function resolveToolDetails(Tool $tool): string
    {
        $origins = $this->originReader->originsByTool($tool);
        if ($origins->isEmpty()) {
            return '-';
        }

        $parts = [];
        foreach ($origins as $origin) {
            $parts[] = Html::getLink($origin->name, UrlGenerator::origin($origin->slug), Bootstrap::CSS_TEXT_DARK);
        }
        return implode(', ', $parts);
    }

    private static function getToolTypes(): array
    {
        return [
            Tool::TYPE_DIVERS => [
                Constant::CST_SLUG => Constant::DIVERS,
                Constant::CST_LABEL => Language::LG_TOOL_DIVERS,
            ],
            Tool::TYPE_GAMES => [
                Constant::CST_SLUG => Constant::GAMES,
                Constant::CST_LABEL => Language::LG_TOOL_GAMES,
            ],
            Tool::TYPE_MUSIC => [
                Constant::CST_SLUG => Constant::MUSIC,
                Constant::CST_LABEL => Language::LG_TOOL_MUSIC,
            ],
            Tool::TYPE_TOOL => [
                Constant::CST_SLUG => Constant::TOOLS,
                Constant::CST_LABEL => Language::LG_TOOL_TOOLS,
            ],
        ];
    }
}
