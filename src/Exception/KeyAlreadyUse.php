<?php
namespace src\Exception;

class KeyAlreadyUse extends \Exception
{
    public function __construct($key, int $code = 0, ?\Throwable $previous = null)
    {
        $message = "La clé '$key' est déjà utilisée dans la collection.";
        parent::__construct($message, $code, $previous);
    }
}
