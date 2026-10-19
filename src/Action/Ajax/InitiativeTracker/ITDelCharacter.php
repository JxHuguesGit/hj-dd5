<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Domain\Entity;
use src\Domain\Entity\ITCharacter;
use src\Service\Writer\InitTrackCharacterWriter;

final class ITDelCharacter extends Entity
{
    public function __construct(
        private InitTrackCharacterWriter $writer,
    ) {}

    public function execute(): array
    {
        $id = (int) filter_input(
            INPUT_POST,
            'character_id',
            FILTER_VALIDATE_INT
        );

        $itCharacter = new ITCharacter();
        $itCharacter->id = $id;
        $this->writer->delete($itCharacter);

        return [
            'status' => 'success'
        ];
    }


}
