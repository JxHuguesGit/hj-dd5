<?php
namespace src\Controller\Admin;

final class AdminHomeContent implements AdminContentInterface
{
    public function getContent(): string
    {
        return 'Hello world';
    }
}
