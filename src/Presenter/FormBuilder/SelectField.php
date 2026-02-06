<?php
namespace src\Presenter\FormBuilder;

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

    public function getOptions(): array { return $this->options; }

    public function renderInput(): string
    {
        $strOptions = '';
        foreach ($this->options as $option) {
            $strOptions .= Html::getOption(
                $option['label'],
                ['value'=>$option['value']],
                $this->value==$option['value']
            );
        }
        $attrs = [
            'id'   => $this->getId(),
            'name' => $this->name,
            'class' => 'form-select',
        ];
        if ($this->readonly) {
            $attrs['readonly'] = 'readonly';
        }

        return Html::getBalise('select', $strOptions, $attrs);
    }
}
