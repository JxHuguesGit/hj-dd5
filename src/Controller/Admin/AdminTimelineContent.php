<?php
namespace src\Controller\Admin;

final class AdminTimelineContent implements AdminContentInterface
{
    public function getContent(): string
    {
        return 'Hello Initiative';
    }
}
