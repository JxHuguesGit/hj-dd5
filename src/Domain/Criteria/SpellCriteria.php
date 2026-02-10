<?php
namespace src\Domain\Criteria;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Field;

final class SpellCriteria
{
    public int $page = 1;
    public string $type = 'append';
    public ?int $minLevel = null;
    public ?int $maxLevel = null;
    public array $classes = [];
    public array $schools = [];
    public bool $onlyRituel = false;
    public bool $onlyConcentration = false;

    /**
     * Transforme l'objet en array compatible WP_Query
     */
    public function toWpQueryArgs(): array
    {
        $args = [
            'post_type'      => 'post',
            'posts_per_page' => 10,
            'category_name'  => 'sort',
            'orderby'        => Bootstrap::CSS_TITLE,
            'order'          => Constant::CST_ASC,
            'paged'          => $this->page,
            'meta_query'     => ['relation' => 'AND'],
        ];

        // Gestion du type "replace"
        if ($this->type === 'replace') {
            $args['posts_per_page'] = 10 * $this->page;
            $args['paged'] = 1;
        }

        // Filtre niveau
        if ($this->minLevel !== null && $this->maxLevel !== null) {
            $args['meta_query'][] = [
                'key'     => Field::NIVEAU,
                Constant::CST_VALUE   => [$this->minLevel, $this->maxLevel],
                Constant::CST_TYPE    => 'NUMERIC',
                'compare' => 'BETWEEN',
            ];
        }

        // Filtre classes
        if (!empty($this->classes) && count($this->classes) < 8) {
            $classConditions = [];
            foreach ($this->classes as $class) {
                $classConditions[] = [
                    'key'     => Field::CLASSES,
                    Constant::CST_VALUE   => '"' . $class . '"',
                    'compare' => 'LIKE',
                ];
            }
            $args['meta_query'][] = [
                'relation' => 'OR',
                ...$classConditions,
            ];
        }

        // Filtre écoles
        if (!empty($this->schools) && count($this->schools) < 8) {
            $args['meta_query'][] = [
                'key'     => Field::SCHOOL,
                Constant::CST_VALUE   => $this->schools,
                'compare' => 'IN',
            ];
        }

        // Filtre rituels
        if ($this->onlyRituel) {
            $args['meta_query'][] = [
                'key'     => 'rituel',
                Constant::CST_VALUE   => '"r"',
                'compare' => 'LIKE'
            ];
        }

        // Filtre concentration
        if ($this->onlyConcentration) {
            $args['meta_query'][] = [
                'key'     => 'concentration',
                Constant::CST_VALUE   => '"c"',
                'compare' => 'LIKE'
            ];
        }

        return $args;
    }

    /**
     * Instancie SpellCriteria depuis $_POST ou un tableau
     */
    public static function fromRequest(array $request): self
    {
        $criteria = new self();
        $criteria->page = (int)($request['page'] ?? 1);
        $criteria->type = $request[Constant::CST_TYPE] ?? 'append';
        $criteria->minLevel = isset($request['levelMinFilter']) ? (int)$request['levelMinFilter'] : null;
        $criteria->maxLevel = isset($request['levelMaxFilter']) ? (int)$request['levelMaxFilter'] : null;
        $criteria->classes = $request['classFilter'] ?? [];
        $criteria->schools = $request['schoolFilter'] ?? [];
        $criteria->onlyRituel = $request['onlyRituel'] ?? false;
        $criteria->onlyConcentration = $request['onlyConcentration'] ?? false;

        return $criteria;
    }
}
