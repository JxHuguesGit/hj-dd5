<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Constant as C;
use src\Factory\WriterFactory;
use src\Utils\Session;

final class DealWithInitTracker
{
    public function __construct(
        private WriterFactory $writerFactory
    ) {}

    public function execute(): array
    {
        $ajaxAction = Session::fromPost(C::AJAXACTION);

        if ($ajaxAction=='addInitChar') {
            return (new ITAddCharacter(
                Session::fromPost(C::CHARACTER),
                $this->writerFactory->initTrackCharacter()
            ))->execute();
        } elseif ($ajaxAction=='delInitChar') {
            return (new ITDelCharacter(
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
