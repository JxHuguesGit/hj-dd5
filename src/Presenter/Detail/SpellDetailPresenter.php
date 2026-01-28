<?php
namespace src\Presenter\Detail;

use src\Constant\Constant;
use src\Domain\Spell as DomainSpell;
use src\Presenter\ViewModel\SpellDetail;
use src\Presenter\ViewModel\SpellPageView;
use src\Service\Domain\WpPostService;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class SpellDetailPresenter
{
    public function __construct(
        private WpPostService $wpPostService
    ) {}

    public function present(
        DomainSpell $spell
    ): SpellDetail {
        return new SpellDetail(
            name: $spell->name,
            url: UrlGenerator::spell($spell->getSlug()),
            niveau: $spell->niveau,
            ecole: $spell->ecole,
            classes: $spell->classes,
            rituel: $spell->rituel,
            tpsInc: $spell->tempsIncantation,
            portee: $spell->portee,
            duree: $spell->duree,
            concentration: $spell->concentration,
            composantes: $spell->composantes,
            composanteMaterielle: $spell->composanteMaterielle,
            description: $spell->content,
            source: '',//TODO : $spell->source
        );
    }

    private function cleanContent(string $content): string
    {
        return preg_replace('/<p>|<\/p>/', '', $content);
    }
}
