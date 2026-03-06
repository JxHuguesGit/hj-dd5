<?php
namespace src\Controller\Compendium;

use src\Constant\Constant as C;
use src\Utils\Session;

abstract class AbstractCompendiumHandler
{
    public function render(): string
    {
        $action = Session::fromGet(C::ACTION);
        $slug   = Session::fromGet(C::SLUG);

        if (Session::isPostSubmitted()) {
            return $this->handleSubmit($action, $slug);
        }

        return match (true) {
            $action === C::EDIT && $slug !== '' => $this->renderEdit($slug),
        //TODO : $action === C::NEW => $this->renderCreate(new Item()),
            default                                    => $this->renderList(),
        };
    }

    protected function handleSubmit(string $action, string $slug): string
    {
        return match ($action) {
            C::EDIT => $this->handleEditSubmit($slug),
        //TODO : C::NEW  => $this->handleNewSubmit(),
            default        => $this->renderList(),
        };
    }

}
