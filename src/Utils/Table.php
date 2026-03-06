<?php
namespace src\Utils;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;

class Table
{
    private Paginate $paginate;
    private bool $blnPaginate  = false;
    public array $attributes   = [];
    private array $header      = [];
    private int $nbHeaderRows  = -1;
    private array $body        = [];
    private int $nbBodyRows    = -1;
    private array $foot        = [];
    private int $nbFootRows    = -1;
    private bool $blnNbPerPage = false;
    private array $filters     = [];
    private bool $blnFilter    = false;

    public function __construct()
    {
        $this->attributes = [
            C::CSSCLASS => B::TABLE,
            'aria-describedby'  => '',
        ];

    }

    public function setTable(array $extraAttributes): self
    {
        if (isset($extraAttributes[C::CSSCLASS])) {
            $this->attributes[C::CSSCLASS] .= ' ' . $extraAttributes[C::CSSCLASS];
            unset($extraAttributes[C::CSSCLASS]);
        }
        $this->attributes = array_merge($this->attributes, $extraAttributes);
        return $this;
    }

    public function setFilter(string $strContent, int $cols = 7): self
    {
        $this->addHeaderRow()
            ->addHeaderCell([
                C::CONTENT    => $strContent,
                C::ATTRIBUTES => [C::COLSPAN => $cols]]);

        return $this;
    }

    public function setNbPerPage(int $refElementId = 1, int $selNbPerPage = 10, array $arrNbPerPage = [], int $cols = 7): self
    {
        $this->blnNbPerPage = true;
        if (empty($arrNbPerPage)) {
            $arrNbPerPage = [10, 25, 50, 100];
        }
        // On modifie le margin-top pour pouvoir inclure cette ligne dans le header
        $this->attributes[C::CSSCLASS] = str_replace(B::MT5, 'mt-2', $this->attributes[C::CSSCLASS]);

        // On construit le contenu de la sélection
        $selectContent = '';
        foreach ($arrNbPerPage as $nbPerPage) {
            $selectContent .= Html::getOption(
                $nbPerPage,
                array_merge(
                    [C::VALUE => $nbPerPage],
                    $nbPerPage == $selNbPerPage ? [C::SELECTED => C::SELECTED] : []
                )
            );
        }
        $strDivDivContent = Html::getBalise(C::LABEL, 'Afficher', ['for' => C::PAGE_NBPERPAGE, C::CSSCLASS => 'col-1 me-2 mb-0 text-end"'])
        . Html::getBalise('select', $selectContent, [C::CSSCLASS => 'form-select form-select-sm w-auto col-1 ajaxAction', 'data-trigger' => 'change', 'data-action' => 'loadTablePage'])
        . Html::getSpan('entrées', [C::CSSCLASS => 'ms-2 col-9 text-start'])
        . Html::getBalise('input', '', [C::TYPE => 'hidden', C::VALUE => $refElementId, C::ID => 'firstElementId', C::NAME => 'firstElementId']);

        $strDivContent = '<!-- Choix du nombre d\'entrées -->'
        . Html::getDiv($strDivDivContent, [C::CSSCLASS => 'row col align-items-center']);

        $strContent = Html::getDiv($strDivContent, [C::CSSCLASS => 'row mx-2 d-flex justify-content-between align-items-center']);
        $this->addHeaderRow()
            ->addHeaderCell([C::CONTENT => $strContent, C::ATTRIBUTES => [C::COLSPAN => $cols]]);
        return $this;
    }

    private function getHeadContent(): string
    {
        $headContent = '';

        if (! empty($this->header['rows'])) {
            foreach ($this->header['rows'] as $row) {
                $rowContent = '';
                foreach ($row['cells'] as $cell) {
                    $cellType  = $cell[C::TYPE];
                    /*
                    // Tentative d'ajouter des div pour le tri. A traiter plus tard.
                    if ($cellType = 'th') {
                        $cellContent = '<div class="dt-column-header"><span>'.$cell[C::CONTENT].'</span><span class="dt-column-order"></span></div>';
                    } else {
                        */
                    $cellContent  = $cell[C::CONTENT];
                    /*
                    }
                        */
                    $cellAttributes  = $cell[C::ATTRIBUTES];
                    $rowContent     .= Html::getBalise($cellType, $cellContent, $cellAttributes);
                }
                $headContent .= Html::getBalise('tr', $rowContent, $row[C::ATTRIBUTES]);
            }
        }
        return $headContent;
    }

    private function getFootContent(): string
    {
        $footContent = '';

        if (! empty($this->foot['rows'])) {
            foreach ($this->foot['rows'] as $row) {
                $rowContent = '';
                foreach ($row['cells'] as $cell) {
                    $cellContent     = $cell[C::CONTENT];
                    $cellType        = $cell[C::TYPE];
                    $cellAttributes  = $cell[C::ATTRIBUTES];
                    $rowContent     .= Html::getBalise($cellType, $cellContent, $cellAttributes);
                }
                $footContent .= Html::getBalise('tr', $rowContent, $row[C::ATTRIBUTES]);
            }
        }

        return $footContent;
    }

    public function display(): string
    {
        $headContent = $this->getHeadContent();
        $bodyContent = '';

        if (! empty($this->body['rows'])) {
            foreach ($this->body['rows'] as $row) {
                $rowContent = '';
                foreach ($row['cells'] as $cell) {
                    $cellContent     = $cell[C::CONTENT] ?? '';
                    $cellType        = $cell[C::TYPE] ?? '';
                    $cellAttributes  = $cell[C::ATTRIBUTES];
                    $rowContent     .= Html::getBalise($cellType, $cellContent, $cellAttributes);
                }
                $bodyContent .= Html::getBalise('tr', $rowContent, $row[C::ATTRIBUTES]);
            }
        }

        $footContent = $this->getFootContent();

        return Html::getBalise(
            B::TABLE,
            Html::getBalise('thead', $headContent, [C::CSSCLASS => $this->header[C::CSSCLASS]]) .
            Html::getBalise('tbody', $bodyContent) .
            Html::getBalise('tfoot', $footContent, [C::CSSCLASS => $this->foot[C::CSSCLASS]]),
            $this->attributes
        );
    }

    public function addHeader(array $attributes = []): self
    {
        $this->header = $attributes;
        return $this;
    }

    public function addHeaderRow(): self
    {
        if ($this->nbHeaderRows == -1) {
            $this->nbHeaderRows = 0;
        } else {
            ++$this->nbHeaderRows;
        }
        $this->header['rows'][$this->nbHeaderRows] = [C::ATTRIBUTES => [], 'cells' => []];
        return $this;
    }

    public function addHeaderCell(array $cell): self
    {
        if (! isset($cell[C::ATTRIBUTES])) {
            $cell[C::ATTRIBUTES] = [];
        }
        if (! isset($cell[C::TYPE])) {
            $cell[C::TYPE] = 'th';
        }
        array_push($this->header['rows'][$this->nbHeaderRows]['cells'], $cell);
        return $this;
    }

    public function addFilteredHeaderCell(array $cell): self
    {
        if (! isset($cell[C::ATTRIBUTES])) {
            $cell[C::ATTRIBUTES] = [];
        }
        if (! isset($cell[C::TYPE])) {
            $cell[C::TYPE] = 'th';
        }

        $strTitle = $cell[C::CONTENT];
        $button   = Html::getButton($strTitle, ['replaceclass' => "btn btn-sm btn-secondary dropdown-toggle", 'data-bs-toggle' => "dropdown", 'aria-expanded' => "false"]);
        $dropdown = '  <ul class="dropdown-menu" style="">
    <li><a class="dropdown-item" href="#">Aberration</a></li>
    <li><a class="dropdown-item" href="#">Bête</a></li>
    <li><a class="dropdown-item" href="#">Humanoïde</a></li>
  </ul>';

        $filterTitle = Html::getDiv($button . $dropdown, [C::CSSCLASS => 'dropdown']);

        $cell[C::CONTENT] = $filterTitle;

        array_push($this->header['rows'][$this->nbHeaderRows]['cells'], $cell);
        return $this;
    }

    public function addBodyRows(mixed $objs, int $colspan = 1, array $arrParams = []): self
    {
        if ($this->blnFilter) {
            $this->addFootRow([C::CSSCLASS => 'table-dark text-center']);
            for ($i = 1; $i <= $colspan; $i++) {
                if (isset($this->filters[$i])) {
                    $filterBlock = $this->filters[$i]->getFilterBlock();
                    $this->addFootCell([C::CONTENT => $filterBlock]);
                } else {
                    $this->addFootCell([C::CONTENT => '&nbsp;']);
                }
            }
        }

        if ($this->blnPaginate) {
            $paginateBlock = $this->paginate->getPaginationBlock();
            if ($paginateBlock != '') {
                $this->addFootRow()
                    ->addFootCell(
                        [C::ATTRIBUTES => [C::COLSPAN => $colspan], C::CONTENT => $paginateBlock]
                    );
            }

            $objs = $objs->slice($this->paginate->getStartSlice(), $this->paginate->getNbPerPage());
        }

        $oldId = -1;
        $cpt   = 1;
        foreach ($objs as $obj) {
            if ($cpt % 2 == 0) {
                $arrParams[C::CSSCLASS] = 'row-striped-even';
            } elseif (isset($arrParams[C::CSSCLASS])) {
                unset($arrParams[C::CSSCLASS]);
            } else {
                //SONAR
            }

            $obj->getController()->addBodyRow($this, $arrParams, $oldId);
            ++$cpt;
        }
        return $this;
    }

    public function addBodyRow(array $attributes = []): self
    {
        if ($this->nbBodyRows == -1) {
            $this->nbBodyRows = 0;
        } else {
            ++$this->nbBodyRows;
        }
        $this->body['rows'][$this->nbBodyRows] = [C::ATTRIBUTES => $attributes, 'cells' => []];
        return $this;
    }

    public function addBodyCell(array $cell): self
    {
        if (! isset($cell[C::ATTRIBUTES])) {
            $cell[C::ATTRIBUTES] = [];
        }
        if (! isset($cell[C::TYPE])) {
            $cell[C::TYPE] = 'td';
        }
        array_push($this->body['rows'][$this->nbBodyRows]['cells'], $cell);
        return $this;
    }

    public function addFooter(array $attributes = []): self
    {
        $this->foot = $attributes;
        return $this;
    }

    public function addFootRow(array $attributes = []): self
    {
        if ($this->nbFootRows == -1) {
            $this->nbFootRows = 0;
        } else {
            ++$this->nbFootRows;
        }
        $this->foot['rows'][$this->nbFootRows] = [C::ATTRIBUTES => $attributes, 'cells' => []];
        return $this;
    }

    public function addFootCell(array $cell): self
    {
        if (! isset($cell[C::ATTRIBUTES])) {
            $cell[C::ATTRIBUTES] = [];
        }
        if (! isset($cell[C::TYPE])) {
            $cell[C::TYPE] = 'th';
        }
        array_push($this->foot['rows'][$this->nbFootRows]['cells'], $cell);
        return $this;
    }

    public function setPaginate(array $paginate = [], array $params = []): self
    {
        $this->blnPaginate = true;
        $this->paginate    = new Paginate($paginate, $params);
        return $this;
    }

}
