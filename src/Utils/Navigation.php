<?php
namespace src\Utils;

use src\Constant\Constant;

final class Navigation
{
    public static function getPrevNext(callable $queryBuilder): array
    {
        $prev = $queryBuilder('&lt;', Constant::DESC)?->first();
        $next = $queryBuilder('&gt;', Constant::ASC)?->first();

        return [
            Constant::PREV => $prev ?: null,
            Constant::NEXT => $next ?: null,
        ];
    }
}
