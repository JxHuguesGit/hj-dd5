<?php

namespace src\Presenter\ContentBuilder;

use src\Presenter\ViewModel\LinkView;
use src\Presenter\ViewModel\SkillDetailView;
use src\Presenter\ViewModel\SubSkillView;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class SkillDetailContentBuilder implements ContentBuilderInterface
{
    public function build(mixed $data, array $params = []): string
    {
        /** @var SkillDetailView $view */
        $view = $data;

        return Html::getDiv(
            $this->renderContent($view),
            ['class' => 'skill-detail']
        );
    }

    private function renderContent(SkillDetailView $view): string
    {
        return
            $this->renderHeader($view)
            . $this->renderDescription($view)
            . $this->renderOrigins($view)
            . $this->renderSubSkills($view)
            . $this->renderNavigation($view);
    }

    private function renderHeader(SkillDetailView $view): string
    {
        return sprintf(
            '<header class="skill-detail-header">
                <h1>%s</h1>
                <span class="skill-ability">%s</span>
            </header>',
            htmlspecialchars($view->name),
            htmlspecialchars($view->ability)
        );
    }

    private function renderDescription(SkillDetailView $view): string
    {
        return Html::getDiv(
            htmlspecialchars($view->description),
            ['class' => 'skill-description']
        );
    }

    private function renderOrigins(SkillDetailView $view): string
    {
        if (!$view->origins) {
            return '';
        }

        $content = '';

        foreach ($view->origins as $origin) {

            /** @var LinkView $origin */

            $content .= Html::getSpan(
                Html::getLink(
                    htmlspecialchars($origin->name),
                    UrlGenerator::origin($origin->slug)
                ),
                ['class' => 'skill-origin']
            );
        }

        return Html::getDiv(
            $content,
            ['class' => 'skill-origins']
        );
    }

    private function renderSubSkills(SkillDetailView $view): string
    {
        if (!$view->subSkills) {
            return '';
        }

        $content = '';

        foreach ($view->subSkills as $subSkill) {

            /** @var SubSkillView $subSkill */

            $content .= sprintf(
                '<article class="subskill">
                    <h2>%s</h2>
                    <p>%s</p>
                </article>',
                htmlspecialchars($subSkill->name),
                htmlspecialchars($subSkill->description)
            );
        }

        return Html::getDiv(
            $content,
            ['class' => 'skill-subskills']
        );
    }

    private function renderNavigation(SkillDetailView $view): string
    {
        $content = '';
        $class = 'skill-navigation';

        if ($view->previous) {
            $content .= Html::getLink(
                '&lt; ' . htmlspecialchars($view->previous->name),
                UrlGenerator::skill($view->previous->slug),
                'btn btn-sm btn-outline-dark'
            );
        }

        if ($view->next) {
            $content .= Html::getLink(
                htmlspecialchars($view->next->name) . ' &gt;',
                UrlGenerator::skill($view->next->slug),
                'btn btn-sm btn-outline-dark'
            );
        }

        if (!$content) {
            return '';
        }

        if (!$view->previous) {
            $class .= ' only-next';
        }

        if (!$view->next) {
            $class .= ' only-prev';
        }

        return Html::getDiv(
            $content,
            ['class' => $class]
        );
    }
}
