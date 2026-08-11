<?php
namespace src\Controller\Admin;

final class AdminCharacterContent implements AdminContentInterface
{
    public function getContent(): string
    {
        return 'Hello Character';
    }
}
