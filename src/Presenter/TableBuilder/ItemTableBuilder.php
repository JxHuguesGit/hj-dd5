<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
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
                UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::GEAR, '', Constant::NEW ),
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
                    Constant::CONTENT    => Html::getLink($item->name, $item->url, B::TEXT_DARK),
                    Constant::ATTRIBUTES => [Constant::CLASS => B::COL_2],
                ])
                ->addBodyCell([Constant::CONTENT => $item->description])
                ->addBodyCell([
                    Constant::CONTENT    => $item->weight,
                    Constant::ATTRIBUTES => [
                        Constant::CLASS => B::TEXT_END . ' ' . B::COL_1,
                    ],
                ])
                ->addBodyCell([
                    Constant::CONTENT    => $item->price,
                    Constant::ATTRIBUTES => [
                        Constant::CLASS => B::TEXT_END . ' ' . B::COL_1,
                    ],
                ]);
            if ($this->isAdmin) {
                $btnEdit = Html::getLink(
                    Html::getIcon(I::EDIT),
                    UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::GEAR, $item->slug, Constant::EDIT),
                    B::TEXT_DARK
                );
                $btnDelete = Html::getLink(
                    Html::getIcon(I::TRASH),
                    UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::GEAR, $item->slug, Constant::DELETE),
                    B::TEXT_DANGER . ' ' . Constant::AJAXACTION,
                    [
                        Constant::DATA => [
                            Constant::TRIGGER     => Constant::CLICK,
                            Constant::ACTION      => 'openConfirm',
                            Constant::TARGET      => 'confirmModal',
                            Constant::TITLE       => 'Suppression de l\'objet ' . $item->name,
                            Constant::DESCRIPTION => 'Confirmez-vous la suppression de l\'objet <strong>' . $item->name . '</strong> ?',
                        ],
                    ]
                );
                $table->addBodyCell([
                    Constant::CONTENT    => $btnEdit . ' ' . $btnDelete,
                    Constant::ATTRIBUTES => [
                        Constant::CLASS => B::TEXT_CENTER . ' ' . B::COL_1]
                    ,
                ]);
            }
        }

        return $table;
    }
}
