<?php
namespace src\Utils;

use src\Collection\Collection;
use src\Constant\Constant;

class Paginate
{
    private $nbPerPage;
    private $option;
    private $nbElements;
    private $nbPages;
    private $curPage;
    private $objs;
    private $url;
    private $pageWidth;
    private $cssPageLink;
    private array $extraParams;

    const PAGE_DEFAULT_WIDTH = 2;

    public function __construct(array $arrData=[], array $params=[])
    {
        /////////////////////////////////////////////////
        // Paramètres optionnels
        // Si on veut personnaliser le nombre de lignes par page
        $this->nbPerPage = $arrData[Constant::PAGE_NBPERPAGE] ?? Constant::PAGE_DEFAULT_NBPERPAGE;
        // Le visuel des boutons de pagination
        $this->option = $arrData[Constant::PAGE_OPTION] ?? Constant::PAGE_OPT_FULL_NMB;
        // Le nombre de pages autour de la page courante
        $this->pageWidth = $arrData[Constant::PAGE_WIDTH] ?? self::PAGE_DEFAULT_WIDTH;
        // Visuel du lien de pagination
        $this->cssPageLink = ' page-link '.($arrData['css-page-link'] ?? '');
        /////////////////////////////////////////////////

        /////////////////////////////////////////////////
        // Paramètres obligatoires
        // On récupère la liste des objets de la pagination.
        // On défini le nombre d'éléments et le nombre de pages
        $this->objs = $arrData[Constant::PAGE_OBJS] ?? new Collection();
        $this->nbElements = $this->objs->count();
        $this->nbPages = ceil($this->nbElements/$this->nbPerPage);
        $curPage = $arrData[Constant::CST_CURPAGE] ?? 1;
        $this->curPage = max(1, min($curPage, $this->nbPages));
        /////////////////////////////////////////////////
        
        $this->extraParams = $params;

        $this->url = remove_query_arg(Constant::CST_CURPAGE);
        $this->dealWithFilterParams($this->url);
        
    }

    public function getPaginationBlock(): string
    {
        $strClass = 'pagination pagination-sm justify-content-start mb-0 col-12 col-sm-6';
        $firstElement = ($this->curPage-1)*$this->nbPerPage*1+1;
        $lastElement  = min($this->nbElements, $this->curPage*$this->nbPerPage);
        $divContent = "Entrées $firstElement à $lastElement sur ".$this->nbElements;
        $navContent = Html::getSpan($divContent, [Constant::CST_CLASS => $strClass]);

        if ($this->nbPages<=1) {
            return $navContent;
        }

        // Selon l'option choisie, on affiche une pagination plus ou moins enrichie.
        $ulContent = '';
        $this->objs->slice(($this->curPage-1)*$this->nbPerPage, $this->nbPerPage);

        // Met-on les numéros ?
        if (in_array(
            $this->option,
            [Constant::PAGE_OPT_NUMBERS,
            Constant::PAGE_OPT_SMP_NMB,
            Constant::PAGE_OPT_FULL_NMB,
            Constant::PAGE_OPT_FST_LAST_NMB]
        )) {
            $ulContent .= $this->getPaginationLink($this->curPage==1, 1, 1);
            if ($this->curPage-$this->pageWidth>2) {
                $ulContent .= $this->getPaginationLink(true, 0, '...');
            }
            $start = max($this->curPage-$this->pageWidth, 2);
            $end = min($this->curPage+$this->pageWidth, $this->nbPages-1);
            for ($i=$start; $i<=$end; $i++) {
                $ulContent .= $this->getPaginationLink($this->curPage==$i, $i, $i);
            }
            if ($this->curPage+$this->pageWidth<$this->nbPages-1) {
                $ulContent .= $this->getPaginationLink(true, 0, '...');
            }
            $ulContent .= $this->getPaginationLink($this->curPage==$this->nbPages, $this->nbPages, $this->nbPages);
        }

        // Met-on previous et next ?
        if (in_array(
            $this->option,
            [Constant::PAGE_OPT_SIMPLE,
            Constant::PAGE_OPT_SMP_NMB,
            Constant::PAGE_OPT_FULL,
            Constant::PAGE_OPT_FULL_NMB]
        )) {
            ////////////////////////////////////////////////////////////////////////////
            // Lien vers la page précédente. Seulement si on n'est pas sur la première.
            $strToPrevious = $this->getPaginationLink(
                $this->curPage<2,
                $this->curPage-1,
                Constant::PAGE_PREVIOUS
            );
            ////////////////////////////////////////////////////////////////////////////
            // Lien vers la page suivante. Seulement si on n'est pas sur la dernière.
            $strToNext = $this->getPaginationLink(
                $this->curPage>=$this->nbPages,
                $this->curPage+1,
                Constant::PAGE_NEXT
            );

            $ulContent = $strToPrevious.$ulContent.$strToNext;
        }

        // Met-on first et last ?
        if (in_array(
            $this->option,
            [Constant::PAGE_OPT_FULL,
            Constant::PAGE_OPT_FULL_NMB,
            Constant::PAGE_OPT_FST_LAST_NMB]
        )) {
            ////////////////////////////////////////////////////////////////////////////
            // Lien vers la première page. Seulement si on n'est ni sur la première, ni sur la deuxième page.
            $strToFirst = $this->getPaginationLink($this->curPage<3, 1, Constant::PAGE_FIRST);
            ////////////////////////////////////////////////////////////////////////////
            // Lien vers la dernière page. Seulement si on n'est pas sur la dernière, ni l'avant-dernière.
            $strToLast = $this->getPaginationLink(
                $this->curPage>=$this->nbPages-1,
                $this->nbPages,
                Constant::PAGE_LAST
            );

            $ulContent = $strToFirst.$ulContent.$strToLast;
        }

        $strClass = 'pagination pagination-sm justify-content-end mb-0 col-6';
        $navContent .= Html::getBalise('ul', $ulContent, [Constant::CST_CLASS => $strClass]);
        $navAttributes = [Constant::CST_CLASS => 'row mx-2', 'aria-label' => 'Pagination liste'];
        return Html::getBalise('nav', $navContent, $navAttributes);
    }

    private function getPaginationLink(bool $isDisabled, int $curpage, string $label): string
    {
        $addClass = '';
        if ($isDisabled) {
            $addClass = ' '.Constant::CST_DISABLED;
            $strLink = Html::getLink($label, '#', $this->cssPageLink);
        } else {
            $href = remove_query_arg('refElementId', $this->url);
            $href = add_query_arg(Constant::CST_CURPAGE, $curpage, $href);
            $strLink = Html::getLink($label, $href, $this->cssPageLink);
        }

        return Html::getLi($strLink, [Constant::CST_CLASS=>'page-item'.$addClass]);
    }
    
    private function dealWithFilterParams(string &$href): void
    {
        if (empty($this->extraParams)) {
            return;
        }

        $filterArgs = [];
        foreach ($this->extraParams as $key => $value) {
            if (strpos($key, 'Filter')===false) {
                continue;
            }
            if (is_array($key)) {
                $nb = count($key);
                for ($i=0; $i<=$nb; $i++) {
                    $href = remove_query_arg($key[$i], $href);
                }
            } else {
                $filterArgs[$key] = $value;
            }
        }
        if (!empty($filterArgs)) {
            $href = add_query_arg($filterArgs, $href);
        }
    }
    
    public function getStartSlice(): int
    {
        return ($this->curPage-1)*$this->nbPerPage;
    }
    
    public function getNbPerPage(): int
    {
        return $this->nbPerPage;
    }
}
