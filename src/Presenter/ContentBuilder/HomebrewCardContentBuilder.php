<?php
namespace src\Presenter\ContentBuilder;

use Override;
use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Service\Domain\WpPostService;
use src\Utils\Html;

final class HomebrewCardContentBuilder
    extends AbstractCardContentBuilder
{
    public function __construct(
        private WpPostService $wpPostServices
    ) {}

    public function build(object $groups): string
    {
        // Id du post Homebrew
        /*
        $wpPost = $this->wpPostServices->getById(1676);
        $contentHtml = $this->renderCard(
                apply_filters('the_content', $wpPost->post_content),
                B::GLOSSAIRE_CARD
            ) .
            $this->getSidebar();
        */
        $contentHtml = '';

        foreach ($groups as $group) {
            $contentHtml .= $this->renderGroup($group);
        }

        return Html::getDiv(
            $contentHtml,
            [C::CSSCLASS => $this->getGroupsClass()]
        );
    }

    private function getSidebar(): string
    {
        return '';
    }
    
    protected function renderItem(object $row): string
    {
        $htmlContent = Html::getBalise('hr', '', [C::CSSCLASS => 'separator']);

        $cardContent =
            Html::getBalise(
                H::BALISE_H3,
                $row->title
            ) .
            Html::getBalise(
                H::BALISE_DIV,
                $row->content
            );

        return $htmlContent .
            $this->renderCard(
                $cardContent,
                B::GLOSSAIRE_CARD
            );
    }

    protected function getGroupId (object $group): string
    {
        return '';
    }

    #[Override]
    protected function getGridClass(): string
    {
        return 'glossary-grid';
    }

    #[Override]
    protected function getGroupClass(): string
    {
        return 'glossary-group max-width-850';
    }
}
