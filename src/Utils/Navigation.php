<?php
namespace src\Utils;

use src\Constant\Constant;

final class Navigation
{
    public static function getPrevNext(callable $queryBuilder): array
    {
        $prev = $queryBuilder('&lt;', Constant::CST_DESC)?->first();
        $next = $queryBuilder('&gt;', Constant::CST_ASC)?->first();

        return [
            Constant::CST_PREV => $prev ?: null,
            Constant::CST_NEXT => $next ?: null,
        ];
    }
}
