<?php
namespace src\Utils;

use src\Collection\Collection;
use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\Translation as RepositoryTranslation;

class Translation
{
    public static array $translations = [];

    public static function translate(string $key, string $lang): string
    {
        $returnedValue = $key;
        $fallbackValue = $key;
        if (isset(self::$translations[$key][$lang])) {
            // La clef est présente et la clef aussi
            $returnedValue = self::$translations[$key][$lang];
        } else {
            // Elle n'est pas présente, on va la chercher en base
            $builder = new QueryBuilder();
            $executor = new QueryExecutor();
            $repository = new RepositoryTranslation($builder, $executor);

            $collection = $repository->findBy([Field::CLEF=>$key]);
            while ($collection->valid()) {
                $objTranslate = $collection->current();
                if ($objTranslate->getLang()==$lang) {
                    $returnedValue = $objTranslate->getValue();
                    self::$translations[$key][$lang] = $returnedValue;
                    break;
                } elseif ($objTranslate->getLang()=='en') {
                    $fallbackValue = $objTranslate->getValue();
                }
                $collection->next();
            }    
        }

        if ($returnedValue==$key && $fallbackValue!=$key)  {
            $returnedValue = $fallbackValue;
            self::$translations[$key][$lang] = $returnedValue;
        }
        return $returnedValue;
    }


}
