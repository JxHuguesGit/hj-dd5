<?php
namespace src\Exception;

final class InterfaceException extends \Exception
{
    /**
     * InterfaceException constructor
     *
     * @param string|int $key La classe qui n'implémente pas son interface
     * @param int $code Code d'exception optionnel
     * @param \Throwable|null $previous Exception précédente
     */
    public function __construct(string | int $class, int $code = 0,  ? \Throwable $previous = null)
    {
        $classStr = is_string($class) ? $class : (string) $class;
        $message  = "La classe '$classStr' doit implémenter son interface.";
        parent::__construct($message, $code, $previous);
    }
}
