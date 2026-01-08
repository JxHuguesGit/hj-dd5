<?php
namespace src\Presenter;

use src\Collection\Collection;

class SkillListPresenter
{
    /**
     * Transforme la collection de compétences en tableau prêt à être rendu par la Page.
     */
    public function present(Collection $skills): array
    {
        $groups = [
            'strength'  => [],
            'dexterity' => [],
            'constitution' => [],
            'intelligence' => [],
            'wisdom' => [],
            'charisma' => [],
        ];

        foreach ($skills as $skill) {
            $abilityId = $skill->abilityId;
            switch ($abilityId) {
                case 1:
                    $groups['strength'][] = $skill;
                    break;
                case 2:
                    $groups['dexterity'][] = $skill;
                    break;
                case 3:
                    $groups['constitution'][] = $skill;
                    break;
                case 4:
                    $groups['intelligence'][] = $skill;
                    break;
                case 5:
                    $groups['wisdom'][] = $skill;
                    break;
                case 6:
                    $groups['charisma'][] = $skill;
                    break;
                default:
                    // Sonar
                    break;
            }
        }

        return ['skills' => [
            [
                'label' => 'Force',
                'skills' => $groups['strength'],
            ],
            [
                'label' => 'Dextérité',
                'skills' => $groups['dexterity'],
            ],
            [
                'label' => 'Constitution',
                'skills' => $groups['constitution'],
            ],
            [
                'label' => 'Intelligence',
                'skills' => $groups['intelligence'],
            ],
            [
                'label' => 'Sagesse',
                'skills' => $groups['wisdom'],
            ],
            [
                'label' => 'Charisme',
                'skills' => $groups['charisma'],
            ],
        ]];
    }
}
