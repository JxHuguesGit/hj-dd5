<?php
namespace src\Utils;

use src\Constant\Constant;

final class Navigation
{
    public static function getPrevNext(callable $queryBuilder): array
    {
        $prev = $queryBuilder('<', Constant::CST_DESC)?->first();
        $next = $queryBuilder('>', Constant::CST_ASC)?->first();

        return [
            Constant::CST_PREV => $prev ?: null,
            Constant::CST_NEXT => $next ?: null,
        ];
    }
}
