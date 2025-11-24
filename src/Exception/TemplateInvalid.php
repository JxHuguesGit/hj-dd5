<?php
namespace src\Exception;

/**
 * Exception levée lorsqu’un template est introuvable.
 */
class TemplateInvalid extends \Exception
{
    /**
     * Nom ou chemin du template manquant.
     */
    protected string $tpl;
    
    /**
     * TemplateInvalid constructor.
     *
     * @param string $tpl Nom ou chemin du template
     * @param string|null $message Message personnalisé (optionnel)
     * @param int $code Code d'exception (optionnel)
     * @param \Throwable|null $previous Exception précédente pour le chaînage (optionnel)
     */
    public function __construct(string $tpl, ?string $message = null, int $code = 0, ?\Throwable $previous = null)
    {
        $this->tpl = $tpl;

        if ($message === null) {
            $message = sprintf(
                "Le template '%s' est introuvable. Vérifier le chemin ou la présence du fichier.",
                $tpl
            );
        }

        parent::__construct($message, $code, $previous);
    }
    
    /**
     * Retourne le nom ou chemin du template manquant.
     */
    public function getTemplateName(): string
    {
        return $this->tpl;
    }
}
