<?php
namespace src\Presenter\FormBuilder;

abstract class FormField
{
    public function __construct(
        protected string $id,
        protected string $name,
        protected string $label,
        protected mixed $value = null,
        protected bool $readonly = false
    ) {}

    public function getId(): string { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getLabel(): string { return $this->label; }
    public function getValue(): mixed { return $this->value; }
    public function isReadonly(): bool { return $this->readonly; }

    abstract public function getType(): string;
}
