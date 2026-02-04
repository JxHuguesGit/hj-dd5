<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant;
use src\Utils\Html;

class SelectField extends FormField
{
    private array $options;

    public function __construct(
        string $id,
        string $name,
        string $label,
        mixed $value = null,
        array $options = [],
        bool $readonly = false
    ) {
        parent::__construct($id, $name, $label, $value, $readonly);
        $this->options = $options;
    }

    public function getType(): string { return 'select'; }
    public function getOptions(): array { return $this->options; }

    public function display(): string
    {
        $readonly = $this->isReadonly() ? 'readonly' : '';

        $strLabel = Html::getBalise(
            'label',
            htmlspecialchars($this->getLabel()),
            ['for' => $this->getId()]
        );

        $strOptions = '';
        foreach ($this->options as $option) {
            $strOptions .= Html::getOption(
                $option['label'],
                ['value'=>$option['value']],
                $this->value==$option['value']
            );
        }

        $strBalise = Html::getBalise(
            'select',
            $strOptions,
            [
                'id'   => $this->getId(),
                'name' => $this->getName(),
                'value' => $this->getValue(),
                $readonly => $readonly
            ]
        );

        return Html::getDiv(
            $strLabel . ' ' . $strBalise,
            [Constant::CST_CLASS => 'mb-3']
        );
    }
}
