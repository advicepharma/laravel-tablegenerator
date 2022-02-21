<?php

namespace Advicepharma\Tablegenerator\Elements;

use Illuminate\Support\Collection;
use Advicepharma\Tablegenerator\Elements\Column;
use Advicepharma\Tablegenerator\Elements\ActionColumn;
use Advicepharma\Tablegenerator\Exceptions\InvalidColumn;

class Table{

    /**
     * Array of columns
     *
     * @var array
     */
    protected array $columns;

    /**
     * Constructor
     */
    public function __construct(){
        $this->columns = [];
    }

    /**
     * Returns all the columns
     *
     * @return array
     */
    public function columns() : array{
        return $this->columns;
    }

    /**
     * Add a new column
     *
     * @param Column|array $column
     * @return Table
     */
    public function addColumn($column){
        if(\is_array($column)){
            foreach($column as $col){
                $this->_addColum($col);
            }
        }else{
            $this->_addColum($column);
        }

        return $this;
    }

    /**
     * Add column to array
     *
     * @param Column $column
     * @return Table
     */
    private function _addColum(Column $column){
        throw_unless(
            $column instanceof Column || $column instanceof ActionColumn,
            InvalidColumn::make($column)
        );

        $this->columns[] = $column;
    }

    /**
     * Generates the columns
     *
     * @return array
     */
    public function generateColumns(){
        return collect($this->columns)
                    ->filter(function ($item, $key) {
                        return $item->permission === "" || auth()->user()->roles->first()->hasPermissionTo($item->permission);
                    })
                    ->toArray();
    }

    /**
     * Generates filters
     *
     * @return array
     */
    public function generateFilters(){
        return collect($this->columns)
                    ->filter(function ($item, $key) {
                        return $item->is_filtrable();
                    })->map(function($item){
                        return $item->field();
                    })
                    ->toArray();
    }

    /**
     * Generate sorts
     *
     * @return array
     */
    public function generateSorts(){
        return collect($this->columns)
                    ->filter(function ($item, $key) {
                        return $item->is_sortable();
                    })->map(function($item){
                        return $item->field();
                    })
                    ->toArray();

    }

}
