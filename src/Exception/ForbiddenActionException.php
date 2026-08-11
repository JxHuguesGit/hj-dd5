<?php
namespace src\Exception;

/**
 * Exception levée lorsqu'une map demandée est active.
 */
final class ForbiddenActionException extends \Exception
{
    /**
     * ForbiddenActionException constructor
     *
     * @param string $msg Message d'erreur
     * @param int $code Code d'exception optionnel
     * @param \Throwable|null $previous Exception précédente
     */
    public function __construct(
        string $msg,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($msg, $code, $previous);
    }
}
