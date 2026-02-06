<?php
namespace src\Factory;

use src\Domain\Item;
use src\Constant\Field;
use src\Utils\Session;
use src\Utils\Utils;

final class ItemFactory
{
    public static function fromPost(): Item
    {
        $attributes = Session::normalizePostData(Item::FIELD_TYPES);
        $attributes[Field::SLUG] = Utils::slugify($attributes[Field::NAME] ?? '');
        $attributes[Field::TYPE] = $attributes[Field::TYPE] ?? 'other';

        return new Item($attributes);
    }

    public static function createEmpty(): Item
    {
        /** @var Item $item */
        $item = EntityFactory::createEmpty(Item::class);
        $item->type = 'other';
        return $item;
    }
}

