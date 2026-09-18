<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant as C;
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
        $size = $this->params[C::SIZE] ?? 5;

        $multiple = $this->params[C::MULTIPLE] ?? false;
        $values = $multiple
            ? (array) $this->value
            : [$this->value];

        $strOptions = '';
        foreach ($this->options as $option) {
            $strOptions .= Html::getOption(
                $option[C::LABEL],
                [C::VALUE => $option[C::VALUE]],
                in_array($option[C::VALUE], $values)
            );
        }
        $attrs = [
            C::ID    => $this->getId(),
            C::NAME  => $multiple ? $this->name . '[]' : $this->name,
            C::CSSCLASS => 'form-select',
        ];
        if ($multiple) {
            $attrs['multiple'] = 'multiple';
            $attrs[C::SIZE] = $size;
        }
        if ($this->readonly) {
            $attrs['readonly'] = 'readonly';
        }

        return Html::getBalise('select', $strOptions, $attrs);
    }
}
