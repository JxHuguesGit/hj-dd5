<?php
namespace src\Exception;

class KeyInvalid extends \Exception
{
    public function __construct($key, int $code = 0, ?\Throwable $previous = null)
    {
        $message = "La clé '$key' n'existe pas dans la collection.";
        parent::__construct($message, $code, $previous);
    }
}
