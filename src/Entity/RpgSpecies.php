<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgSpecies as ControllerRpgSpecies;
use src\Repository\RpgSpecies as RepositoryRpgSpecies;
use WP_Post;

class RpgSpecies extends Entity
{
    public const TABLE = 'rpgSpecies';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::SLUG,
        Field::PARENTID,
        Field::POSTID,
    ];

    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::SLUG => 'string',
        Field::PARENTID => 'intPositive',
        Field::POSTID => 'intPositive',
    ];
    
    protected string $name = '';
    protected string $slug = '';
    protected int $parentId = 0;
    protected int $postId = 0;

    private ?WP_Post $wpPostCache = null;

    // TODO : à externaliser
    public function getController(): ControllerRpgSpecies
    {
        $controller = new ControllerRpgSpecies();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function stringify(): string
    {
        return $this->getFullName();
    }

    public function getFullName(): string
    {
        if ($this->parentId==0) {
            return $this->name;
        } else {
            return $this->getSpecies()->getFullName().' ('.$this->name.')';
        }
    }

    public function getSpecies(): ?RpgSpecies
    {
        return $this->getRelatedEntity('speciesCache', RepositoryRpgSpecies::class, $this->parentId);
    }
    
    public function getWpPost(): ?WP_Post
    {
        if ($this->wpPostCache === null) {
            $this->wpPostCache = get_post($this->postId) ?: null;
        }
        return $this->wpPostCache;
    }
}
