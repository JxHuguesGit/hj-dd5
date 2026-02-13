<?php
namespace src\Presenter\TableBuilder;

use src\Constant\{Bootstrap, Constant, Icon, Language};
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class ItemTableBuilder extends AbstractTableBuilder
{
    public function __construct(
        private bool $isAdmin=false
    ) {}

    public function build(iterable $rows, array $params = []): Table
    {
        $headers = [Language::LG_GEAR, Language::LG_DESCRIPTION, Language::LG_WEIGHT, Language::LG_PRICE];
        if ($this->isAdmin) {
            $createLink = Html::getLink(
                Html::getIcon(Icon::IPLUS),
                UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::CST_GEAR, '', Constant::NEW),
                Bootstrap::CSS_TEXT_WHITE
            );
            $headers[] = $createLink;
        }

        $table = $this->createTable(count($headers), $params);

        // Headers
        foreach ($headers as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }

        foreach ($rows as $item) {
            /** @var DomainItem $item */
            $table->addBodyRow([])
                ->addBodyCell([
                    Constant::CST_CONTENT => Html::getLink($item->name, $item->url, Bootstrap::CSS_TEXT_DARK),
                    Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_COL_2]
                ])
                ->addBodyCell([Constant::CST_CONTENT => $item->description])
                ->addBodyCell([
                    Constant::CST_CONTENT => $item->weight,
                    Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END . ' ' . Bootstrap::CSS_COL_1]
                ])
                ->addBodyCell([
                    Constant::CST_CONTENT => $item->price,
                    Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END . ' ' . Bootstrap::CSS_COL_1]
                ]);
            if ($this->isAdmin) {
                $table->addBodyCell([
                    Constant::CST_CONTENT => Html::getLink(
                        Html::getIcon(Icon::IEDIT),
                        UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::CST_GEAR, $item->slug, Constant::EDIT),
                        Bootstrap::CSS_TEXT_DARK
                    ),
                    Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_CENTER . ' ' . Bootstrap::CSS_COL_1],
                ]);
            }
        }

        return $table;
    }
}
