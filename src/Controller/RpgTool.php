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
