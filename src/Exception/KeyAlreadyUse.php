<?php
namespace src\Exception;

/**
 * Exception levée lorsqu'une clé est déjà utilisée dans une collection.
 */
final class KeyAlreadyUse extends \Exception
{
    /**
     * KeyAlreadyUse constructor
     *
     * @param string|int $key La clé déjà utilisée
     * @param int $code Code d'exception optionnel
     * @param \Throwable|null $previous Exception précédente
     */
    public function __construct(string|int $key, int $code = 0, ?\Throwable $previous = null)
    {
        $message = "La clé '$key' est déjà utilisée dans la collection.";
        parent::__construct($message, $code, $previous);
    }
}
