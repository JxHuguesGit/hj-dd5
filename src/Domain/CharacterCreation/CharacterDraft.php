<?php
namespace src\Domain\CharacterCreation;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

final class CharacterDraft extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::WPUSERID,
        Field::ORIGINID,
        Field::SPECIESID,
        Field::CREATESTEP,
        Field::DATA,
        Field::LASTUPDATE,
    ];

    public const FIELD_TYPES = [
        Field::NAME       => FieldType::STRINGNULLABLE,
        Field::WPUSERID   => FieldType::INT,
        Field::ORIGINID   => FieldType::INTNULLABLE,
        Field::SPECIESID  => FieldType::INTNULLABLE,
        Field::CREATESTEP => FieldType::STRING,
        Field::DATA       => FieldType::JSON,
        Field::LASTUPDATE => FieldType::DATETIME,
    ];

    public function isComplete(): bool {
        return $this->createStep === null || $this->createStep === 'done';
    }

    public function getDataField(string $key, mixed $default = null): mixed {
        if ($this->data === null) {
            return $default;
        }
        $decoded = is_array($this->data) ? $this->data : json_decode($this->data, true);
        return $decoded[$key] ?? $default;
    }

    public function setDataField(string $key, mixed $value): void {
        $decoded = is_array($this->data) ? $this->data : json_decode($this->data, true);
        $decoded[$key] = $value;
        $this->data = $decoded;
    }

    public function stringify(): string {
        return $this->name ?? '(Sans nom)';
    }

    public function touch(): void {
        $this->lastUpdate = date('Y-m-d H:i:s');
    }

}
