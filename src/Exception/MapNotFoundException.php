<?php
namespace src\Exception;


/**
 * Exception levée lorsqu'une map demandée n'existe pas.
 */
final class MapNotFoundException extends \Exception
{
    /**
     * MapNotFound constructor
     *
     * @param int $mapId Identifiant de la map introuvable
     * @param int $code Code d'exception optionnel
     * @param \Throwable|null $previous Exception précédente
     */
    public function __construct(
        int $mapId,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        $message = "La map '$mapId' est introuvable.";
        parent::__construct($message, $code, $previous);
    }
}
