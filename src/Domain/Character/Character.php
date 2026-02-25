<?php
namespace src\Domain\Character;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Session;

final class Character extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::WPUSERID,
        Field::NAME,
        Field::ORIGINID,
        Field::SPECIESID,
        Field::CREATESTEP,
        Field::DONNEES,
        Field::LASTUPDATE,
    ];

    public const FIELD_TYPES = [
        Field::WPUSERID   => FieldType::INT,
        Field::NAME       => FieldType::STRINGNULLABLE,
        Field::ORIGINID   => FieldType::INTNULLABLE,
        Field::SPECIESID  => FieldType::INTNULLABLE,
        Field::CREATESTEP => FieldType::STRING,
        Field::DONNEES    => FieldType::JSONNULLABLE,
        Field::LASTUPDATE => FieldType::DATETIME,
    ];

    public function initialize(array $input = []): self
    {
        if (isset($input['characterId']) && $input['characterId'] != 0) {
            $this->id = $input['characterId'];
        }
        if (isset($input['characterName']) && $input['characterName'] != 0) {
            $this->name = $input['characterName'];
        }
        if ($this->createStep === null || $this->createStep === '') {
            $this->createStep = Constant::CST_NAME;
        } elseif (isset($input['createStep'])) {
            $this->createStep = $input['createStep'];
        }
        if (isset($input['characterOriginId']) && $input['characterOriginId'] != 0) {
            $this->originId = $input['characterOriginId'];
        }

        $this->wpUserId  = Session::getWpUser()->data->ID;
        $this->speciesId = null;
        $this->donnees   = json_encode([]);

        return $this;
    }
    public function isComplete(): bool
    {
        return $this->createStep === Constant::CST_DONE;
    }

    public function getDataField(string $key, mixed $default = null): mixed
    {
        if (! is_string($this->donnees) || $this->donnees === '') {
            return $default;
        }

        $decoded = json_decode($this->donnees, true);

        if (! is_array($decoded)) {
            return $default;
        }

        return $decoded[$key] ?? $default;
    }

    public function setDataField(string $key, mixed $value): void
    {
        // On récupère le JSON existant (ou array vide si vide/null)
        $decoded = is_string($this->donnees) && $this->donnees !== ''
            ? json_decode($this->donnees, true)
            : [];

        if (! is_array($decoded)) {
            $decoded = [];
        }

        $decoded[$key] = $value;
        $this->donnees = json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }

    public function stringify(): string
    {
        return $this->name ?? '(Sans nom)';
    }

    public function touch(): void
    {
        $this->lastUpdate = date('Y-m-d H:i:s');
    }

}
