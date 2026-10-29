<?php

namespace src\Constant;

final class AoeConfig
{
    public const GRID_SIZE = 8;
    public const MIN_X = -self::GRID_SIZE;
    public const MAX_X = self::GRID_SIZE;
    public const MIN_Y = -self::GRID_SIZE;
    public const MAX_Y = self::GRID_SIZE;

    public static function getWidth(): int
    {
        return self::MAX_X - self::MIN_X + 1;
    }

    public static function getHeight(): int
    {
        return self::MAX_Y - self::MIN_Y + 1;
    }
}
