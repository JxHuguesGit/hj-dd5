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
            $action === C::EDIT && $slug !== '' => $this->renderEdit((int)$slug),
            $action === C::NEW                  => $this->renderEdit(),
            default                             => $this->renderList(),
        };
    }

    protected function handleSubmit(string $action, string $slug): string
    {
        return match ($action) {
            C::EDIT => $this->handleEditSubmit((int)$slug),
            C::NEW  => $this->handleNewSubmit(),
            default => $this->renderList(),
        };
    }

    protected function renderEdit(?int $slug = 0): string
    {
        return '';
    }

    protected function renderNew(): string
    {
        return '';
    }

    protected function renderList(): string
    {
        return '';
    }

    protected function handleEditSubmit(int $slug): string
    {
        return '';
    }

    protected function handleNewSubmit(): string
    {
        return '';
    }
}
