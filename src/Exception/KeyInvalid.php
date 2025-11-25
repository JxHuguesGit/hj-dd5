<?php
namespace src\Exception;

final class KeyInvalid extends \Exception
{
    /**
     * KeyInvalid constructor
     *
     * @param string|int $key La clé invalide
     * @param int $code Code d'exception optionnel
     * @param \Throwable|null $previous Exception précédente
     */
    public function __construct(string|int $key, int $code = 0, ?\Throwable $previous = null)
    {
        $keyStr = is_string($key) ? $key : (string)$key;
        $message = "La clé '$keyStr' n'existe pas dans la collection.";
        parent::__construct($message, $code, $previous);
    }
}
