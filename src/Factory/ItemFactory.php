<?php
namespace src\Factory;

use src\Domain\Entity\Item;
use src\Constant\Field as F;
use src\Utils\Session;
use src\Utils\Utils;

final class ItemFactory
{
    public static function fromPost(): Item
    {
        $attributes = Session::normalizePostData(Item::FIELD_TYPES);
        $attributes[F::SLUG] = Utils::slugify($attributes[F::NAME] ?? '');
        $attributes[F::TYPE] = $attributes[F::TYPE] ?? 'other';

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

