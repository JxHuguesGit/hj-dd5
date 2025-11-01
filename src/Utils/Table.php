<?php
namespace src\Utils;

use src\Constant\Constant;

class Table
{
    private Paginate $paginate;
    private bool $blnPaginate = false;
    private array $attributes = [];
    private array $header = [];
    private int $nbHeaderRows = -1;
    private array $body = [];
    private int $nbBodyRows = -1;
    private array $foot = [];
    private int $nbFootRows = -1;
    private bool $blnNbPerPage = false;
    private array $filters = [];
    private bool $blnFilter = false;

    public function __construct()
    {
        $this->attributes = [
            Constant::CST_CLASS=>'table',
            'aria-describedby' => '',//'Liste des missions',
        ];

    }

    public function setTable(array $extraAttributes): self
    {
        if (isset($extraAttributes[Constant::CST_CLASS])) {
            $this->attributes[Constant::CST_CLASS] .= ' '.$extraAttributes[Constant::CST_CLASS];
            unset($extraAttributes[Constant::CST_CLASS]);
        }
        $this->attributes = array_merge($this->attributes, $extraAttributes);
        return $this;
    }
    
    public function setFilter(string $strContent, int $cols=7): self
    {
        $this->addHeaderRow()
             ->addHeaderCell([Constant::CST_CONTENT=>$strContent, 'attributes'=>['colspan'=>$cols]]);
    
        return $this;
    }
    
    public function setNbPerPage(int $refElementId=1, int $selNbPerPage=10, array $arrNbPerPage=[], int $cols=7): self
    {
        $this->blnNbPerPage = true;
        if (empty($arrNbPerPage)) {
            $arrNbPerPage = [10, 25, 50, 100];
        }
        // On modifie le margin-top pour pouvoir inclure cette ligne dans le header
        $this->attributes[Constant::CST_CLASS] = str_replace('mt-5', 'mt-2', $this->attributes[Constant::CST_CLASS]);
        
        // On construit le contenu de la sélection
        $selectContent = '';
        foreach ($arrNbPerPage as $nbPerPage) {
            $selectContent .= Html::getOption($nbPerPage, array_merge(['value'=>$nbPerPage], $nbPerPage==$selNbPerPage ? ['selected'=>'selected'] : []));
        }
        $strDivDivContent  = Html::getBalise('label', 'Afficher', ['for'=>Constant::PAGE_NBPERPAGE, Constant::CST_CLASS=>'col-1 me-2 mb-0 text-end"'])
                           . Html::getBalise('select', $selectContent, [Constant::CST_CLASS=>'form-select form-select-sm w-auto col-1 ajaxAction', 'data-trigger'=>'change', 'data-action'=>'loadMonsterPage'])
                           . Html::getSpan('entrées', [Constant::CST_CLASS=>'ms-2 col-9 text-start'])
                           . Html::getBalise('input', '', [Constant::CST_TYPE=>'hidden', Constant::CST_VALUE=>$refElementId, Constant::CST_ID=>'refElementId', Constant::CST_NAME=>'refElementId']);
        
        $strDivContent = '<!-- Choix du nombre d\'entrées -->'
                       . Html::getBalise('div', $strDivDivContent, [Constant::CST_CLASS=>'row col align-items-center']);
        
        $strContent = Html::getBalise('div', $strDivContent, [Constant::CST_CLASS=>'row mx-2 d-flex justify-content-between align-items-center']);
        $this->addHeaderRow()
             ->addHeaderCell([Constant::CST_CONTENT=>$strContent, 'attributes'=>['colspan'=>$cols]]);
        return $this;
    }

    private function getHeadContent(): string
    {
        $headContent = '';
        
        if (!empty($this->header['rows'])) {
            foreach ($this->header['rows'] as $row) {
                $rowContent = '';
                foreach ($row['cells'] as $cell) {
                    $cellType = $cell[Constant::CST_TYPE];
                    /*
                    // Tentative d'ajouter des div pour le tri. A traiter plus tard.
                    if ($cellType = 'th') {
                        $cellContent = '<div class="dt-column-header"><span>'.$cell[Constant::CST_CONTENT].'</span><span class="dt-column-order"></span></div>';
                    } else {
                        */
                        $cellContent = $cell[Constant::CST_CONTENT];
                        /*
                    }
                        */
                    $cellAttributes = $cell['attributes'];
                    $rowContent .= Html::getBalise($cellType, $cellContent, $cellAttributes);
                }
                $headContent .= Html::getBalise('tr', $rowContent, $row['attributes']);
            }
        }
        return $headContent;
    }

    private function getFootContent(): string
    {
        $footContent = '';

        if (!empty($this->foot['rows'])) {
            foreach ($this->foot['rows'] as $row) {
                $rowContent = '';
                foreach ($row['cells'] as $cell) {
                    $cellContent = $cell[Constant::CST_CONTENT];
                    $cellType = $cell[Constant::CST_TYPE];
                    $cellAttributes = $cell['attributes'];
                    $rowContent .= Html::getBalise($cellType, $cellContent, $cellAttributes);
                }
                $footContent .= Html::getBalise('tr', $rowContent, $row['attributes']);
            }
        }
    
        return $footContent;
    }

    public function display(): string
    {
        $headContent = $this->getHeadContent();
        $bodyContent = '';


        if (!empty($this->body['rows'])) {
            foreach ($this->body['rows'] as $row) {
                $rowContent = '';
                foreach ($row['cells'] as $cell) {
                    $cellContent = $cell[Constant::CST_CONTENT];
                    $cellType = $cell[Constant::CST_TYPE];
                    $cellAttributes = $cell['attributes'];
                    $rowContent .= Html::getBalise($cellType, $cellContent, $cellAttributes);
                }
                $bodyContent .= Html::getBalise('tr', $rowContent, $row['attributes']);
            }
        }

        $footContent = $this->getFootContent();

        return Html::getBalise(
            'table',
            Html::getBalise('thead', $headContent, [Constant::CST_CLASS=>$this->header[Constant::CST_CLASS]]).
            Html::getBalise('tbody', $bodyContent).
            Html::getBalise('tfoot', $footContent),
            $this->attributes
        );
    }

    public function addHeader(array $attributes=[]): self
    {
        $this->header = $attributes;
        return $this;
    }

    public function addHeaderRow(): self
    {
        if ($this->nbHeaderRows==-1) {
            $this->nbHeaderRows = 0;
        } else {
            ++$this->nbHeaderRows;
        }
        $this->header['rows'][$this->nbHeaderRows] = ['attributes'=>[], 'cells'=>[]];
        return $this;
    }
    
    public function addHeaderCell(array $cell): self
    {
        if (!isset($cell['attributes'])) {
            $cell['attributes'] = [];
        }
        if (!isset($cell[Constant::CST_TYPE])) {
            $cell[Constant::CST_TYPE] = 'th';
        }
        array_push($this->header['rows'][$this->nbHeaderRows]['cells'], $cell);
        return $this;
    }
    
    public function addFilteredHeaderCell(array $cell): self
    {
        if (!isset($cell['attributes'])) {
            $cell['attributes'] = [];
        }
        if (!isset($cell[Constant::CST_TYPE])) {
            $cell[Constant::CST_TYPE] = 'th';
        }
        
        $strTitle = $cell[Constant::CST_CONTENT];
        $button = Html::getButton($strTitle, ['replaceclass'=>"btn btn-sm btn-secondary dropdown-toggle", 'data-bs-toggle'=>"dropdown", 'aria-expanded'=>"false"]);
        $dropdown = '  <ul class="dropdown-menu" style="">
    <li><a class="dropdown-item" href="#">Aberration</a></li>
    <li><a class="dropdown-item" href="#">Bête</a></li>
    <li><a class="dropdown-item" href="#">Humanoïde</a></li>
  </ul>';
  
        $filterTitle = Html::getDiv($button.$dropdown, ['class'=>'dropdown']);
        
        $cell[Constant::CST_CONTENT] = $filterTitle;
        
        array_push($this->header['rows'][$this->nbHeaderRows]['cells'], $cell);
        return $this;
    }
    
    public function addBodyRows(mixed $objs, int $colspan=1, array $arrParams=[]): self
    {
        if ($this->blnFilter) {
            $this->addFootRow([Constant::CST_CLASS=>'table-dark text-center']);
            for ($i=1; $i<=$colspan; $i++) {
                if (isset($this->filters[$i])) {
                    $filterBlock = $this->filters[$i]->getFilterBlock();
                    $this->addFootCell([Constant::CST_CONTENT=>$filterBlock]);
                } else {
                    $this->addFootCell([Constant::CST_CONTENT=>'&nbsp;']);
                }
            }
        }
        
        if ($this->blnPaginate) {
            $paginateBlock = $this->paginate->getPaginationBlock();
            if ($paginateBlock!='') {
                $this->addFootRow()
                    ->addFootCell(
                        ['attributes'=>['colspan'=>$colspan], Constant::CST_CONTENT=>$paginateBlock]
                    );
            }
            
            $objs = $objs->slice($this->paginate->getStartSlice(), $this->paginate->getNbPerPage());
        }
        
        $oldId = -1;
        $objs->rewind();
        $cpt = 1;
        while ($objs->valid()) {
            $obj = $objs->current();
            if ($cpt%2==0) {
                $arrParams[Constant::CST_CLASS] = 'row-striped-even';
            } elseif (isset($arrParams[Constant::CST_CLASS])) {
                unset($arrParams[Constant::CST_CLASS]);
            } else {
                //SONAR
            }

            $obj->getController()->addBodyRow($this, $arrParams, $oldId);
            $objs->next();
            ++$cpt;
        }
        return $this;
    }

    public function addBodyRow(array $attributes=[]): self
    {
        if ($this->nbBodyRows==-1) {
            $this->nbBodyRows = 0;
        } else {
            ++$this->nbBodyRows;
        }
        $this->body['rows'][$this->nbBodyRows] = ['attributes'=>$attributes, 'cells'=>[]];
        return $this;
    }

    public function addBodyCell(array $cell): self
    {
        if (!isset($cell['attributes'])) {
            $cell['attributes'] = [];
        }
        if (!isset($cell[Constant::CST_TYPE])) {
            $cell[Constant::CST_TYPE] = 'td';
        }
        array_push($this->body['rows'][$this->nbBodyRows]['cells'], $cell);
        return $this;
    }
    
    public function addFootRow(array $attributes=[]): self
    {
        if ($this->nbFootRows==-1) {
            $this->nbFootRows = 0;
        } else {
            ++$this->nbFootRows;
        }
        $this->foot['rows'][$this->nbFootRows] = ['attributes'=>$attributes, 'cells'=>[]];
        return $this;
    }
    
    public function addFootCell(array $cell): self
    {
        if (!isset($cell['attributes'])) {
            $cell['attributes'] = [];
        }
        if (!isset($cell[Constant::CST_TYPE])) {
            $cell[Constant::CST_TYPE] = 'th';
        }
        array_push($this->foot['rows'][$this->nbFootRows]['cells'], $cell);
        return $this;
    }
    
    public function setPaginate(array $paginate=[], array $params=[]): self
    {
        $this->blnPaginate = true;
        $this->paginate = new Paginate($paginate, $params);
        return $this;
    }

}
