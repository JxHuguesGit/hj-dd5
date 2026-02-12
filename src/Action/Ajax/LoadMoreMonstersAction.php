<?php
namespace src\Action\Ajax;

use src\Service\Ajax\MonsterAjax;

class LoadMoreMonstersAction implements AjaxActionInterface
{
    public function execute(): mixed
    {
        return MonsterAjax::loadMoreMonsters();
    }
}
