<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Domain\Feat as DomainFeat;
use src\Utils\Utils;

class FeatListPresenter
{
    private Collection $feats;
    private Utils $utils;

    public function __construct(Collection $feats)
    {
        $this->feats = $feats;
        $this->utils = new Utils();
    }

    public function render(): string
    {
        if ($this->feats->isEmpty()) {
            return '<p>Aucun don disponible dans cette catégorie.</p>';
        }

        $html = '<div class="row gy-4">';

        foreach ($this->feats as $feat) {
            $html .= $this->renderCard($feat);
        }

        $html .= '</div>';

        return $html;
    }

    private function renderCard(DomainFeat $feat): string
    {
        $name = htmlspecialchars($feat->name);
        $desc = 'TODO';//nl2br(htmlspecialchars($feat->getShortDescription() ?? ''));
        $url  = '/don-' . $feat->getSlug();

        return <<<HTML
<div class="col-12 col-md-6">
    <a href="{$url}" class="text-decoration-none text-dark">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">{$name}</h5>
                <p class="card-text">{$desc}</p>
            </div>
        </div>
    </a>
</div>
HTML;
    }
}
