<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant;
use src\Utils\Html;

class SelectField extends FormField
{
    private array $options;

    public function __construct(
        string $name,
        string $label,
        mixed $value = null,
        array $options = [],
        protected array $params = [],
    ) {
        parent::__construct($name, $label, $value, false, $params);
        $this->options = $options;
    }

    public function getOptions(): array
    {return $this->options;}

    public function renderInput(): string
    {
        $strOptions = '';
        foreach ($this->options as $option) {
            $strOptions .= Html::getOption(
                $option[Constant::CST_LABEL],
                [Constant::CST_VALUE => $option[Constant::CST_VALUE]],
                $this->value == $option[Constant::CST_VALUE]
            );
        }
        $attrs = [
            Constant::CST_ID    => $this->getId(),
            Constant::CST_NAME  => $this->name,
            Constant::CST_CLASS => 'form-select',
        ];
        if ($this->readonly) {
            $attrs['readonly'] = 'readonly';
        }

        return Html::getBalise('select', $strOptions, $attrs);
    }
}
