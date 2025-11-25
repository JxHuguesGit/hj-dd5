<?php
namespace src\Action;

use src\Controller\Utilities;
use src\Utils\Session;

class LoadCasteDetail
{
    public static function build(): string
    {
        $key = Session::fromPost('key');
    
        $utilities = new Utilities();
        $attributes = [
            $key,
            'TODO'
        ];
        return $utilities->getRender(constant("src\Constant\Template::CASTE_DETAIL_{$key}"), $attributes);
    }

}
