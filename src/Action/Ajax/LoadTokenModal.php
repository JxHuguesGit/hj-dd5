<?php
namespace src\Action\Ajax;

use src\Domain\Criteria\MonsterCriteria;
use src\Factory\ReaderFactory;
use src\Factory\PresenterFactory;

final class LoadTokenModal
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private PresenterFactory $presenterFactory,
    ) {}

    public function execute(): array
    {
        $criteria = new MonsterCriteria();

        return [
            'status' => 'success',
            'data' => [
                'title' => 'Ajouter un token',
                'content' => $this->presenterFactory
                    ->token()
                    ->presentAddTokenModal(
                        $this->readerFactory
                            ->monster()
                            ->allMonsters($criteria)
                    ),
                'action' => [
                    'label' => 'Ajouter',
                    'ajaxAction' => 'addToken',
                ],
            ],
        ];
    }
}
