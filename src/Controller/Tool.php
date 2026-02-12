<?php
namespace src\Controller;

use src\Domain\Tool as DomainTool;

class Tool extends Utilities
{
    protected DomainTool $rpgTool;

    public function __construct()
    {
        parent::__construct();

        $this->title = 'Outils';
    }

    public function getCheckboxForm(bool $checked=false, bool $readonly=false): string
    {
        $id = $this->rpgTool->id;
        $name = $this->rpgTool->name;
        $returned = sprintf(
            '<div class="form-check"><input class="" type="checkbox"%1s value="%2s" id="tool%2s"%3s%4s><label class="form-check-label" for="tool%2s">%5s</label></div>',
            $readonly?'':' name="toolId[]"',
            $id,
            $checked?' checked':'',
            $readonly?' disabled':'',
            $name
        );
        if ($readonly) {
            $returned .= '<input type="hidden" name="toolId[]" value="'.$id.'"/>';
        }
        return $returned;
    }
}
