<?php
namespace src\Renderer;

use src\Exception\TemplateInvalid;

final class TemplateRenderer
{
    public function render(string $template, array $args = []): string
    {
        $path = PLUGIN_PATH . $template;

        if (!is_file($path)) {
            throw new TemplateInvalid($template);
        }

        return vsprintf(file_get_contents($path), $args);
    }
}
