<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Domain\Entity\Monster;
use src\Presenter\ViewModel\MonsterRow;
use src\Service\Formatter\MonsterFormatter;
use src\Service\Reader\ReferenceReader;

final class MonsterListPresenter
{
    private Monster $monster;

    public function __construct(
        private MonsterFormatter $monsterFormatter,
        private ReferenceReader $reader
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
            cr: $this->monsterFormatter->formatCR($this->monster->cr),
            type: '',//$presenter->getStrType(),
            ca: $this->monster->ca,
            hp: $this->monster->hp,
            reference: ($this->reader->referenceById($this->monster->referenceId))->name ?? '-'
        );
    }

    public function displayName(): string
    {
        $name = $this->monster->isComplete() && $this->monster->frName !== ''
            ? $this->monster->frName
            : $this->monster->name;

        return $this->monsterFormatter->formatNameWithFlags(
            $name,
            $this->monster->id,
            $this->monster->isComplete(),
            $this->monster->ukTag,
            $this->monster->frTag
        );
    }
}

