<?php
namespace src\Controller;

use src\Constant\Field;
use src\Entity\RpgTool as EntityRpgTool;

class RpgTool extends Utilities
{
    protected EntityRpgTool $rpgTool;

    public function __construct()
    {
        parent::__construct();

        $this->title = 'Outils';
    }

    public function getCheckboxForm(bool $checked=false, bool $readonly=false): string
    {
        $id = $this->rpgTool->getField(Field::ID);
        $name = $this->rpgTool->getField(Field::NAME);
        $returned = '<div class="form-check">'
                . '<input class="" type="checkbox"'.($readonly?'':' name="toolId[]"').' value="'.$id.'" id="tool'.$id.'"'.($checked?' checked':'').($readonly?' disabled':'').'>'
                . '<label class="form-check-label" for="tool'.$id.'">'.$name.'</label>'
                . '</div>';
        if ($readonly) {
        $returned .= '<input type="hidden" name="toolId[]" value="'.$id.'"/>';
        }
        return $returned;
    }
}
