<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\Template as T;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Renderer\TemplateRenderer;

/**
 * @property string $name
 * @property int $level
 * @property int $ac
 * @property int $maxHp
 * @property int $modDex
 * @property int $percPassive
 * @property int $initiativeTrackerId
 */

final class ITCharacter extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
        F::LEVEL,
        F::SCOREAC,
        F::MAXHP,
        F::MODDEX,
        F::PERCPASSIVE,
        F::ITID,
    ];

    public const FIELD_TYPES = [
        F::NAME        => FieldType::STRING,
        F::LEVEL       => FieldType::INTPOSITIVE,
        F::SCOREAC     => FieldType::INTPOSITIVE,
        F::MAXHP       => FieldType::INTPOSITIVE,
        F::MODDEX      => FieldType::INT,
        F::PERCPASSIVE => FieldType::INTPOSITIVE,
        F::ITID        => FieldType::INTPOSITIVE,
    ];

    public const EDITABLE_FIELDS = [
        F::NAME,
        F::LEVEL,
        F::SCOREAC,
        F::MAXHP,
        F::MODDEX,
        F::PERCPASSIVE,
    ];

    public function getCharacterStats(): string
    {
        return sprintf(
            'Niveau %d • CA %d • %d PV • DEX %s • Passive %d',
            $this->level,
            $this->ac,
            $this->maxHp,
            ($this->modDex>0 ? '+' : '') . $this->modDex,
            $this->percPassive
        );
    }


    public function buildAside(TemplateRenderer $renderer): string
    {
        return $renderer->render(
            T::ADMIN_IT_PARTY_MEMBER,
            [
                $this->name,
                $this->getCharacterStats(),
                $this->id
            ]
        );
    }
}