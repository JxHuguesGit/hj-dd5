<?php
namespace src\Presenter\Detail;

use src\Domain\Entity\Skill;
use src\Presenter\ViewModel\LinkView;
use src\Presenter\ViewModel\SkillDetailView;
use src\Presenter\ViewModel\SkillPageView;
use src\Utils\Utils;

class SkillDetailPresenter
{
    public function present(
        SkillPageView $viewData
    ): SkillDetailView {
        return new SkillDetailView(
            name: $viewData->skill->name,
            slug: $viewData->skill->slug,
            ability: $viewData->ability->name,
            description: Utils::formatBBCode($viewData->skill->description),
            origins: $this->buildOrigins($viewData),
            subSkills: $this->buildSubSkills($viewData),
            previous: $this->buildLink($viewData?->previous),
            next: $this->buildLink($viewData?->next)
        );
    }

    private function buildOrigins(SkillPageView $viewData): array
    {
        $parts = [];
        foreach ($viewData->origins as $origin) {
            $parts[] = new LinkView(
                name: $origin->name,
                slug: $origin->slug
            );
        }
        return $parts;
    }

    private function buildSubSkills(SkillPageView $viewData): array
    {
        $parts = [];
        foreach ($viewData->subSkills as $subSkill) {
            $parts[] = new SkillDetailView(
                name: $subSkill->name ?? '',
                slug: $subSkill->slug,
                ability: '',
                description: Utils::formatBBCode($subSkill->description ?? ''),
                origins: [],
                subSkills: [],
                previous: null,
                next: null
            );
        }
        return $parts;
    }

    private function buildLink(?Skill $skill): ?LinkView
    {
        if ($skill === null) {
            return null;
        }
        return new LinkView(
            name: $skill->name,
            slug: $skill->slug
        );
    }
}
