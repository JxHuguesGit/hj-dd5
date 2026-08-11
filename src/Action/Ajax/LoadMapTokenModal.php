<?php
namespace src\Action\Ajax;

use src\Factory\ReaderFactory;
use src\Factory\PresenterFactory;

final class LoadMapTokenModal
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private PresenterFactory $presenterFactory,
    ) {}

    public function execute(): array
    {
        return [
            'status' => 'success',
            'data' => [
                'title' => 'Ajouter un token',
                'content' => $this->presenterFactory
                    ->token()
                    ->presentAddModal(
                        $this->readerFactory
                            ->token()
                            ->activeTokens()
                    ),
                'action' => [
                    'label' => 'Ajouter',
                    'ajaxAction' => 'addMapToken',
                ],
            ],
        ];
    }
}
