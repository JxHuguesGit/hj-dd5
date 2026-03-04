<?php
namespace src\Presenter\MenuPresenter;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Constant\Template;
use src\Presenter\ViewModel\MenuItem;
use src\Utils\UrlGenerator;

class TimelineMenuPresenter
{
    public function render(string $currentTab, callable $renderer): string
    {
        $item = new MenuItem(
            id: Constant::ONG_TIMELINE,
            label: Language::LG_INITIATIVE,
            icon: Constant::ONG_TIMELINE
        );

        $isActive = ($currentTab === Constant::ONG_TIMELINE);

        $attributes = [
            '',
            UrlGenerator::admin(Constant::ONG_TIMELINE, ''),
            $isActive ? Constant::CST_ACTIVE : '',
            $item->icon,
            $item->label,
            Bootstrap::CSS_DNONE,
            '',
            '', '',
        ];

        return $renderer(Template::ADMINSIDEBARITEM, $attributes);
    }
}
