<?php
namespace src\Action\Ajax;

use src\Service\Ajax\MonsterAjax;

class ModalMonsterCard
{
    public function execute(): mixed
    {
        return MonsterAjax::loadModal();
    }
}
