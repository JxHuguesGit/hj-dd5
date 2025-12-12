<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\Entity;
use src\Exception\NotFoundException;
use src\Factory\RepositoryFactory;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;
use src\Page\PageOrigine;
use src\Presenter\MenuPresenter;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Model\PageRegistry;

class PublicOrigine extends PublicBase
{
    private $origin;

    public function __construct(string $slug, PageOrigine $pageOrigine)
    {
        $repo = RepositoryFactory::create(RepositoryRpgOrigin::class);
        $this->origin = $repo->findBy([Field::SLUG=>$slug]);

        if (!$this->origin) {
            throw new NotFoundException("Origine introuvable : " . $slug);
        } else {
            $this->origin = $this->origin->first();
        }

        // Construire le PageElement dynamique
        $pageElement = $pageOrigine->getPageElement([
            'slug' => $this->origin->getSlug(),
            'title' => $this->origin->getName(),
            'url' => '/origine-' . $this->origin->getSlug(),
        ]);
        PageRegistry::getInstance()->register($pageElement);
        $this->pageElement = $pageElement;
        
        $this->title = $this->origin->getName();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        $registry = PageRegistry::getInstance();
        $menuHtml = (new MenuPresenter($registry->all(), 'origines'))->render();
        
        if (!$this->origin) {
            return $this->getRender(Template::NOT_FOUND, [$menuHtml]);
        }
        
        Entity::setSharedDependencies(new QueryBuilder(), new QueryExecutor());
        
        $repo = RepositoryFactory::create(RepositoryRpgOrigin::class);
        $nextOrigins = $repo->findByComplex([['field'=>Field::NAME, 'operand'=>'>', 'value'=>$this->origin->getName()]], [Field::NAME=>Constant::CST_ASC], 1);
        $prevOrigins = $repo->findByComplex([['field'=>Field::NAME, 'operand'=>'<', 'value'=>$this->origin->getName()]], [Field::NAME=>Constant::CST_DESC], 1);

        $abilities = [];
        $originAbilities = $this->origin->getOriginAbilities();
        foreach ($originAbilities as $originAbility) {
            $abilities[] = $originAbility->getAbility()->getName();
        }
        
        $skills = [];
        $originSkills = $this->origin->getOriginSkills();
        foreach ($originSkills as $originSkill) {
            $skills[] = $originSkill->getSkill()->getName();
        }

        $strContent = $this->origin->getWpPost()->post_content;
        $strContent = preg_replace('/<p>|<\/p>/', '', $strContent);

        $strEquipment = get_field('equipement', $this->origin->getWpPost()->ID);

        if ($prevOrigins->isEmpty()) {
            $strPrev = '<span></span>';
        } else {
            $prevOrigin = $prevOrigins->first();
            $strPrev = '<a class="btn btn-sm btn-outline-dark" href="/origine-'.$prevOrigin->getSlug().'">&lt; '.$prevOrigin->getName().'</a>';
        }
        if ($nextOrigins->isEmpty()) {
            $strNext = '<span></span>';
        } else {
            $nextOrigin = $nextOrigins->first();
            $strNext = '<a class="btn btn-sm btn-outline-dark" href="/origine-'.$nextOrigin->getSlug().'">'.$nextOrigin->getName().' &gt;</a>';
        }

        $attributes = [
            // Image pour illustrer
            '',
            $this->title,// Titre
            $strContent,
            implode(', ', $abilities),
            implode(', ', $skills),
            $this->origin->getOriginFeat()->getName(),
            $this->origin->getOriginTool()->getName(),
            $strEquipment,
            $strPrev,
            $strNext,
        ];
        $contentHtml = $this->getRender(TEMPLATE::ORIGIN_DETAIL_CARD, $attributes);
        $contentSection = $this->getRender(Template::DETAIL_PAGE, ['', $contentHtml]);
        
        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}
