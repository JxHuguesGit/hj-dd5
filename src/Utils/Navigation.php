<?php
namespace src\Utils;

use src\Constant\Constant as C;

final class Navigation
{
    public static function getPrevNext(callable $queryBuilder): array
    {
        $prev = $queryBuilder('&lt;', C::DESC)?->first();
        $next = $queryBuilder('&gt;', C::ASC)?->first();

        return [
            C::PREV => $prev ?: null,
            C::NEXT => $next ?: null,
        ];
    }
}
