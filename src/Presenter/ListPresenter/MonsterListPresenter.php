<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Domain\Monster\Monster;
use src\Presenter\ViewModel\MonsterRow;
use src\Service\Formatter\MonsterFormatter;

final class MonsterListPresenter
{
    private Monster $monster;

    public function __construct(
        private MonsterFormatter $monsterFormatter
    ) {}

    public function present(iterable $monsters): Collection
    {
        $collection = new Collection();
        foreach ($monsters as $this->monster) {
            $collection->add($this->buildRow());
        }
        return $collection;
    }

    private function buildRow(): MonsterRow
    {
        return new MonsterRow(
            name: $this->displayName(),
            ukTag: $this->monster->ukTag,
            cr: $this->monsterFormatter->formatCR($this->monster->cr),
            type: $this->formatType(),
            ca: $this->monster->ca,
            hp: $this->monster->hp,
            reference: $this->monster->reference()->getLabel() ?? '-'
        );
    }

    public function displayName(): string
    {
        $name = $this->monster->isComplete() && $this->monster->frName !== ''
            ? $this->monster->frName
            : $this->monster->name;

        return $this->monsterFormatter->formatNameWithFlags(
            $name,
            $this->monster->isComplete(),
            $this->monster->ukTag,
            $this->monster->frTag
        );
    }

    private function formatType(): string
    {
        $typeName = $this->monster->type()->getName();
        $subTypeName = $this->monster->subType()->getName();

        return $subTypeName
            ? sprintf('%s (%s)', $typeName, $subTypeName)
            : $typeName;
    }

}

