<?php
namespace src\Utils;

use src\Constant\Constant;
use src\Utils\Paginate;

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

    public function display(): string
    {
        $headContent = '';
        $bodyContent = '';
        $footContent = '';

        foreach ($this->header['rows'] as $row) {
            $rowContent = '';
            foreach ($row['cells'] as $cell) {
                $cellType = $cell[Constant::CST_TYPE];
                if ($cellType = 'th') {
	                $cellContent = '<div class="dt-column-header"><span>'.$cell[Constant::CST_CONTENT].'</span><span class="dt-column-order"></span></div>';
                } else {
    	            $cellContent = $cell[Constant::CST_CONTENT];
                }
                $cellAttributes = $cell['attributes'];
                $rowContent .= Html::getBalise($cellType, $cellContent, $cellAttributes);
            }
            $headContent .= Html::getBalise('tr', $rowContent, $row['attributes']);
        }

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
    
    public function addBodyRows(mixed $objs, int $colspan=1, array $arrParams=[]): self
    {
        /*
        if ($this->blnFilter) {
            $this->addFootRow();
            for ($i=1; $i<=$colspan; $i++) {
                if (isset($this->filters[$i])) {
                    $filterBlock = $this->filters[$i]->getFilterBlock();
                    $this->addFootCell([ConstantConstant::CST_CONTENT=>$filterBlock]);
                } else {
                    $this->addFootCell([ConstantConstant::CST_CONTENT=>ConstantConstant::CST_NBSP]);
                }
            }
        }
        */
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
    
    public function addFootRow(): self
    {
        if ($this->nbFootRows==-1) {
            $this->nbFootRows = 0;
        } else {
            ++$this->nbFootRows;
        }
        $this->foot['rows'][$this->nbFootRows] = ['attributes'=>[], 'cells'=>[]];
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
    
    public function setPaginate(array $paginate=[]): self
    {
        $this->blnPaginate = true;
        $this->paginate = new Paginate($paginate);
        return $this;
    }
    
    /**
    private array $filters = [];
    private bool $blnFilter = false;
    
     * $header = [
     *      'attributes' => [],
     *      'rows'       => [
     *          0 => [
     *              'attributes' => [],
     *              'cells' => [
     *                  0 => [
     *                      'attributes'=>[]
     *                      ConstantConstant::CST_CONTENT=>'',
     *                      'type'=>'',
     *                  ]
     *              ]
     *          ]
     *      ]
     * ];
     * /





    






    public function setFilter(array $filter=[]): self
    {
        $this->blnFilter = true;
        $this->filters[$filter[ConstantConstant::CST_COL]] = new FilterUtils($filter);
        return $this;
    }


        */
}