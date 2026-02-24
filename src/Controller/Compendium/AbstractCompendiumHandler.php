<?php
namespace src\Controller\Compendium;

use src\Constant\Constant;
use src\Utils\Session;

abstract class AbstractCompendiumHandler
{
    public function render(): string
    {
        $action = Session::fromGet(Constant::CST_ACTION);
        $slug   = Session::fromGet(Constant::CST_SLUG);

        if (Session::isPostSubmitted()) {
            return $this->handleSubmit($action, $slug);
        }

        return match (true) {
            $action === Constant::EDIT && $slug !== '' => $this->renderEdit($slug),
        //TODO : $action === Constant::NEW => $this->renderCreate(new Item()),
            default                                    => $this->renderList(),
        };
    }

    protected function handleSubmit(string $action, string $slug): string
    {
        return match ($action) {
            Constant::EDIT => $this->handleEditSubmit($slug),
        //TODO : Constant::NEW  => $this->handleNewSubmit(),
            default        => $this->renderList(),
        };
    }

}
