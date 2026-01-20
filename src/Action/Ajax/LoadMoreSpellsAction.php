<?php
namespace src\Action\Ajax;

use src\Service\Ajax\SpellAjax;

class LoadMoreSpellsAction implements AjaxActionInterface
{
    public function execute(): mixed
    {
        return SpellAjax::loadMoreSpells();
    }
}
