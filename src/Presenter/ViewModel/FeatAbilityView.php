<?php
namespace src\Presenter\ViewModel;

use src\Enum\AbilityEnum;

final class FeatAbilityView
{
    public int $id;
    public AbilityEnum $slug;
    public string $label;
    public bool $checked;

    public function __construct(int $id, AbilityEnum $slug, string $label, bool $checked)
    {
        $this->id      = $id;
        $this->slug    = $slug;
        $this->label   = $label;
        $this->checked = $checked;
    }
}
