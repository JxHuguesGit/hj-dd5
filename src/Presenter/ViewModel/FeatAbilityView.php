<?php
namespace src\Presenter\ViewModel;

final class FeatAbilityView
{
    public int $id;
    public string $label;
    public bool $checked;

    public function __construct(int $id, string $label, bool $checked)
    {
        $this->id      = $id;
        $this->label   = $label;
        $this->checked = $checked;
    }
}
