<?php

namespace src\Action\Ajax;

use src\Domain\Criteria\MonsterCriteria;
use src\Factory\ReaderFactory;

final class LoadCombatMonstersAction implements AjaxActionInterface
{
    public function __construct(
        private ReaderFactory $readerFactory,
    ) {}

    public function execute(): array
    {
        $criteria = new MonsterCriteria();

        $name = trim((string) filter_input(INPUT_POST, 'name'));
        if ($name !== '') {
            $criteria->name = '%' . $name . '%';
        }

        $referenceId = filter_input(INPUT_POST, 'referenceId', FILTER_VALIDATE_INT);
        if ($referenceId !== false && $referenceId !== null) {
            $criteria->referenceId = $referenceId;
        }

        $scoreCr = filter_input(INPUT_POST, 'scoreCr');
        if ($scoreCr !== false && $scoreCr !== null && $scoreCr !== '') {
            $criteria->cr = (float) $scoreCr;
        }

        $limit = filter_input(INPUT_POST, 'limit', FILTER_VALIDATE_INT);
        $offset = filter_input(INPUT_POST, 'offset', FILTER_VALIDATE_INT);

        $limit = $limit > 0 ? $limit : 20;
        $offset = $offset >= 0 ? $offset : 0;

        $criteria->limit = $limit + 1;
        $criteria->offset = $offset;

        $monsters = $this->readerFactory
            ->monster()
            ->allMonsters($criteria);
        $hasMore = count($monsters) > $limit;

        $items = [];

        foreach ($monsters->slice(0, $limit) as $monster) {
            $items[] = [
                'id'     => $monster->id,
                'name'   => $monster->name,
                'scoreCr' => $monster->cr,
            ];
        }

        return [
            'items' => $items,
            'hasMore' => $hasMore,
        ];
    }
}
