<?php
namespace src\Controller\Admin;

use src\Constant\Template as T;
use src\Controller\Utilities;

final class AdminNav extends Utilities
{
    public function getContent(): string
    {
        return $this->getRender(T::ADMINNAV);
    }
}
