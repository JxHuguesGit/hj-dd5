<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
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
        $headers = [L::NAMES, L::DESCRIPTION, L::WEIGHT, L::PRICE];
        if ($this->isAdmin) {
            $createLink = Html::getLink(
                Html::getIcon(I::PLUS),
                UrlGenerator::admin(C::ONG_COMPENDIUM, C::GEAR, '', C::NEW ),
                B::TEXT_WHITE
            );
            $headers[] = $createLink;
        }

        $table = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($rows as $item) {
            /** @var Item $item */
            $table->addBodyRow([])
                ->addBodyCell([
                    C::CONTENT    => Html::getLink($item->name, $item->url, B::TEXT_DARK),
                    C::ATTRIBUTES => [C::CSSCLASS => B::COL_2],
                ])
                ->addBodyCell([C::CONTENT => $item->description])
                ->addBodyCell([
                    C::CONTENT    => $item->weight,
                    C::ATTRIBUTES => [
                        C::CSSCLASS => B::TEXT_END . ' ' . B::COL_1,
                    ],
                ])
                ->addBodyCell([
                    C::CONTENT    => $item->price,
                    C::ATTRIBUTES => [
                        C::CSSCLASS => B::TEXT_END . ' ' . B::COL_1,
                    ],
                ]);
            if ($this->isAdmin) {
                $btnEdit = Html::getLink(
                    Html::getIcon(I::EDIT),
                    UrlGenerator::admin(C::ONG_COMPENDIUM, C::GEAR, $item->slug, C::EDIT),
                    B::TEXT_DARK
                );
                $btnDelete = Html::getLink(
                    Html::getIcon(I::TRASH),
                    UrlGenerator::admin(C::ONG_COMPENDIUM, C::GEAR, $item->slug, C::DELETE),
                    B::TEXT_DANGER . ' ' . C::AJAXACTION,
                    [
                        C::DATA => [
                            C::TRIGGER     => C::CLICK,
                            C::ACTION      => 'openConfirm',
                            C::TARGET      => 'confirmModal',
                            C::TITLE       => 'Suppression de l\'objet ' . $item->name,
                            C::DESCRIPTION => 'Confirmez-vous la suppression de l\'objet <strong>' . $item->name . '</strong> ?',
                        ],
                    ]
                );
                $table->addBodyCell([
                    C::CONTENT    => $btnEdit . ' ' . $btnDelete,
                    C::ATTRIBUTES => [
                        C::CSSCLASS => B::TEXT_CENTER . ' ' . B::COL_1]
                    ,
                ]);
            }
        }

        return $table;
    }
}
