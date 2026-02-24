<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Domain\Entity\Item;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class ItemTableBuilder extends AbstractTableBuilder
{
    public function __construct(
        private bool $isAdmin = false
    ) {}

    public function build(iterable $rows, array $params = []): Table
    {
        $headers = [Language::LG_NAMES, Language::LG_DESCRIPTION, Language::LG_WEIGHT, Language::LG_PRICE];
        if ($this->isAdmin) {
            $createLink = Html::getLink(
                Html::getIcon(Icon::IPLUS),
                UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::CST_GEAR, '', Constant::NEW ),
                Bootstrap::CSS_TEXT_WHITE
            );
            $headers[] = $createLink;
        }

        $table = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($rows as $item) {
            /** @var Item $item */
            $table->addBodyRow([])
                ->addBodyCell([
                    Constant::CST_CONTENT    => Html::getLink($item->name, $item->url, Bootstrap::CSS_TEXT_DARK),
                    Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_COL_2],
                ])
                ->addBodyCell([Constant::CST_CONTENT => $item->description])
                ->addBodyCell([
                    Constant::CST_CONTENT    => $item->weight,
                    Constant::CST_ATTRIBUTES => [
                        Constant::CST_CLASS => Bootstrap::CSS_TEXT_END . ' ' . Bootstrap::CSS_COL_1,
                    ],
                ])
                ->addBodyCell([
                    Constant::CST_CONTENT    => $item->price,
                    Constant::CST_ATTRIBUTES => [
                        Constant::CST_CLASS => Bootstrap::CSS_TEXT_END . ' ' . Bootstrap::CSS_COL_1,
                    ],
                ]);
            if ($this->isAdmin) {
                $table->addBodyCell([
                    Constant::CST_CONTENT    => Html::getLink(
                        Html::getIcon(Icon::IEDIT),
                        UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::CST_GEAR, $item->slug, Constant::EDIT),
                        Bootstrap::CSS_TEXT_DARK
                    ),
                    Constant::CST_ATTRIBUTES => [
                        Constant::CST_CLASS => Bootstrap::CSS_TEXT_CENTER . ' ' . Bootstrap::CSS_COL_1]
                    ,
                ]);
            }
        }

        return $table;
    }
}
