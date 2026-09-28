<?php
namespace src\Presenter\ViewModel;

final class ClasseView
{
    public int $id;
    public string $slug;
    public string $label;
    public bool $checked;

    public function __construct(int $id, string $slug, string $label, bool $checked)
    {
        $this->id      = $id;
        $this->slug    = $slug;
        $this->label   = $label;
        $this->checked = $checked;
    }
}
