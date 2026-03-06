<?php
namespace src\Presenter\MenuPresenter;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Constant\Template;
use src\Presenter\ViewModel\MenuItem;
use src\Utils\UrlGenerator;

class TimelineMenuPresenter
{
    public function render(string $currentTab, callable $renderer): string
    {
        $item = new MenuItem(
            id: C::ONG_TIMELINE,
            label: L::INITIATIVE,
            icon: C::ONG_TIMELINE
        );

        $isActive = ($currentTab === C::ONG_TIMELINE);

        $attributes = [
            '',
            UrlGenerator::admin(C::ONG_TIMELINE, ''),
            $isActive ? C::ACTIVE : '',
            $item->icon,
            $item->label,
            B::DNONE,
            '',
            '', '',
        ];

        return $renderer(Template::ADMINSIDEBARITEM, $attributes);
    }
}
