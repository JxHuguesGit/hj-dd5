<?php

declare(strict_types=1);

namespace Tests\Presenter\ContentBuilder;

use PHPUnit\Framework\TestCase;
use src\Presenter\ContentBuilder\FeatDetailContentBuilder;
use src\Presenter\ViewModel\FeatDetailView;
use src\Presenter\ViewModel\FeatTypeView;
use src\Presenter\ViewModel\LinkView;

final class FeatDetailContentBuilderTest extends TestCase
{
    public function testBuildsFeatDetail(): void
    {
        $view = new FeatDetailView(
            name: 'Artisan',
            slug: 'artisan',
            description: 'Vous maîtrisez certains outils.',
            type: new FeatTypeView(
                label: 'Origine',
                slug: 'origine'
            ),
            origins: [
                new LinkView('Acolyte', 'acolyte'),
            ],
            previous: new LinkView('Athlète', 'athlete'),
            next: new LinkView('Observateur', 'observateur'),
        );

        $builder = new FeatDetailContentBuilder();

        $html = $builder->build($view);

        $this->assertStringContainsString(
            '<article',
            $html
        );

        $this->assertStringContainsString(
            'Artisan',
            $html
        );

        $this->assertStringContainsString(
            'Origine',
            $html
        );

        $this->assertStringContainsString(
            'Vous maîtrisez certains outils.',
            $html
        );

        $this->assertStringContainsString(
            'Acolyte',
            $html
        );

        $this->assertStringContainsString(
            'Athlète',
            $html
        );

        $this->assertStringContainsString(
            'Observateur',
            $html
        );
    }

    public function testDoesNotRenderEmptyDescription(): void
    {
        $view = new FeatDetailView(
            name: 'Test Feat',
            slug: 'test-feat',
            description: '',
            type: new FeatTypeView(
                label: 'General',
                slug: 'general'
            ),
            origins: [],
            previous: null,
            next: null,
        );

        $builder = new FeatDetailContentBuilder();

        $html = $builder->build($view);

        $this->assertStringNotContainsString(
            'data-detail-description',
            $html
        );
    }

    public function testDoesNotRenderOriginsWhenThereAreNone(): void
    {
        $view = new FeatDetailView(
            name: 'Test Feat',
            slug: 'test-feat',
            description: 'Une description.',
            type: new FeatTypeView(
                label: 'General',
                slug: 'general'
            ),
            origins: [],
            previous: null,
            next: null,
        );

        $builder = new FeatDetailContentBuilder();

        $html = $builder->build($view);

        $this->assertStringNotContainsString(
            'feat-origins',
            $html
        );
    }

    public function testRendersOrigins(): void
    {
        $view = new FeatDetailView(
            name: 'Test Feat',
            slug: 'test-feat',
            description: 'Une description.',
            type: new FeatTypeView(
                label: 'General',
                slug: 'general'
            ),
            origins: [
                new LinkView(
                    name: 'Acolyte',
                    slug: 'acolyte'
                ),
            ],
            previous: null,
            next: null,
        );

        $builder = new FeatDetailContentBuilder();

        $html = $builder->build($view);

        $this->assertStringContainsString(
            'class="feat-origins"',
            $html
        );

        $this->assertStringContainsString(
            'href="/origine-acolyte"',
            $html
        );

        $this->assertStringContainsString(
            '>Acolyte</a>',
            $html
        );
    }

    public function testRendersHeader(): void
    {
        $view = new FeatDetailView(
            name: 'Expert en compétences',
            slug: 'expert-en-competences',
            description: '',
            type: new FeatTypeView(
                label: 'Don général',
                slug: 'don-general'
            ),
            origins: [],
            previous: null,
            next: null,
        );

        $builder = new FeatDetailContentBuilder();

        $html = $builder->build($view);

        $this->assertStringContainsString(
            '<h1>Expert en compétences</h1>',
            $html
        );

        $this->assertStringContainsString(
            'href="/feats-don-general"',
            $html
        );

        $this->assertStringContainsString(
            '>Don général</a>',
            $html
        );
    }

    public function testRendersTypePrerequisite(): void
    {
        $view = new FeatDetailView(
            name: 'Expert en compétences',
            slug: 'expert-en-competences',
            description: '',
            type: new FeatTypeView(
                label: 'Don général',
                slug: 'don-general',
                prerequisite: 'Prérequis : niveau 4'
            ),
            origins: [],
            previous: null,
            next: null,
        );

        $builder = new FeatDetailContentBuilder();

        $html = $builder->build($view);

        $this->assertStringContainsString(
            '>Don général</a>',
            $html
        );

        $this->assertStringContainsString(
            'Prérequis : niveau 4',
            $html
        );
    }

    public function testRendersNavigation(): void
    {
        $view = new FeatDetailView(
            name: 'Expert en compétences',
            slug: 'expert-en-competences',
            description: 'Description du don.',
            type: new FeatTypeView(
                label: 'Don général',
                slug: 'don-general'
            ),
            origins: [],
            previous: new LinkView('Don précédent', 'don-precedent'),
            next: new LinkView('Don suivant', 'don-suivant'),
        );

        $builder = new FeatDetailContentBuilder();
        $html = $builder->build($view);

        $this->assertStringContainsString(
            'href="/feat-don-precedent"',
            $html
        );

        $this->assertStringContainsString(
            'href="/feat-don-suivant"',
            $html
        );

        $this->assertStringContainsString(
            '&lt; Don précédent',
            $html
        );

        $this->assertStringContainsString(
            'Don suivant &gt;',
            $html
        );
    }
}
