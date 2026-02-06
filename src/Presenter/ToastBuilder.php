<?php
namespace src\Presenter;

use src\Constant\Template;
use src\Renderer\TemplateRenderer;

final class ToastBuilder
{
    private TemplateRenderer $renderer;

    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    private function build(string $type, string $title, string $message): string
    {
        return $this->renderer->render(
            Template::MAIN_TOAST,
            [$title, $message, ' show bg-'.$type]
        );
    }

    public function success(string $title, string $message): string
    {
        return $this->build('success', $title, $message);
    }

    public function error(string $title, string $message): string
    {
        return $this->build('danger', $title, $message);
    }

    public function info(string $title, string $message): string
    {
        return $this->build('info', $title, $message);
    }
}
