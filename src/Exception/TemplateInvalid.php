<?php
namespace src\Exception;

class TemplateInvalid extends \Exception
{
    public function __construct(string $tpl, int $code = 0, ?\Throwable $previous = null)
    {
        $message = "Fichier $tpl introuvable.<br>Vérifier le chemin ou la présence du fichier.";
        parent::__construct($message, $code, $previous);
    }
}
