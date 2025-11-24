<?php
namespace src\Utils;

use Throwable;

class ExceptionRenderer
{
    public static function handle(Throwable $e): void
    {
        echo self::renderExceptionCard($e);
    }

    private static function renderExceptionCard(Throwable $exception): string
    {
        $html = '<div class="card border-danger p-0" style="max-width:100%;margin-right:15px;">';
        $html .= '<div class="card-header bg-danger text-white"><strong>Exception levée</strong></div>';
        $html .= '<div class="card-body">';
        
        $html .= self::renderExceptionChain($exception);

        $html .= '</div>';
        $html .= '<div class="card-footer"></div>';
        $html .= '</div>';

        return $html;
    }

    private static function renderExceptionChain(Throwable $exception): string
    {
        $html = '';
        for ($obj = $exception; $obj !== null; $obj = $obj->getPrevious()) {
            $html .= '<p><strong>Message :</strong> ' . htmlspecialchars($obj->getMessage()) . '</p>';
            $html .= '<p>Fichier : <strong>' . $obj->getFile() . '</strong> à la ligne <strong>' . $obj->getLine() . '</strong></p>';
            $html .= self::renderTrace($obj->getTrace());

            if ($obj->getPrevious()) {
                $html .= '<hr>';
            }
        }
        return $html;
    }

    private static function renderTrace(array $trace): string
    {
        if (empty($trace)) {
            return '';
        }

        $html = '<ul class="list-group">';
        foreach ($trace as $t) {
            $file = $t['file'] ?? '[internal function]';
            $line = $t['line'] ?? '';
            $fn   = ($t['class'] ?? '') . ($t['type'] ?? '') . ($t['function'] ?? '');
            $args = self::formatArgs($t['args'] ?? []);
            $html .= '<li class="list-group-item">'.htmlspecialchars($file).' ('.$line.') : '.$fn.$args.'</li>';
        }
        $html .= '</ul>';

        return $html;
    }

    private static function formatArgs(array $args): string
    {
        if (empty($args)) {
            return '';
        }

        $list = array_map(function($arg){
            return match(true) {
                is_object($arg) => 'Object('.get_class($arg).')',
                is_array($arg)  => 'Array['.count($arg).']',
                is_null($arg)   => 'NULL',
                is_bool($arg)   => $arg ? 'true' : 'false',
                default         => (string)$arg,
            };
        }, $args);

        return '('.implode(', ', $list).')';
    }
}
