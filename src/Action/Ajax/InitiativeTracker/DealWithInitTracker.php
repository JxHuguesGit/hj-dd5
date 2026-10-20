<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Constant as C;
use src\Factory\ReaderFactory;
use src\Factory\WriterFactory;
use src\Utils\Session;

final class DealWithInitTracker
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private WriterFactory $writerFactory
    ) {}

    public function execute(): array
    {
        $ajaxAction = Session::fromPost(C::AJAXACTION);

        if ($ajaxAction=='addInitChar') {
            $returnedArray = (new ITAddCharacter(
                Session::fromPost(C::CHARACTER),
                $this->writerFactory->initTrackCharacter()
            ))->execute();
        } elseif ($ajaxAction=='addInitCharToCombat') {
            $returnedArray = (new ITAddCharacterToCombat(
                Session::fromPost('character_id'),
                Session::fromPost('initiativeTrackerId'),
                $this->readerFactory->initTrackCharacter(),
                $this->readerFactory->initiativeTracker(),
                $this->writerFactory->initTrackCharacter()
            ))->execute();
        } elseif ($ajaxAction=='delInitChar') {
            $returnedArray = (new ITDelCharacter(
                $this->writerFactory->initTrackCharacter()
            ))->execute();
        } elseif ($ajaxAction=='updateInitChar') {
            $returnedArray = (new ITMajCharacter(
                Session::fromPost(C::CHARACTER),
                $this->writerFactory->initTrackCharacter()
            ))->execute();
        } else {
            $returnedArray = [
                'status' => 'error',
                'message' => 'Action non identifiée.',
            ];
        }

        return $returnedArray;
    }

}
