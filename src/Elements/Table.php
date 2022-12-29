<?php

namespace Advicepharma\Tablegenerator\Elements;

use Advicepharma\Tablegenerator\Exceptions\InvalidColumn;

class Table
{
    /**
     * Array of columns
     *
     * @var array
     */
    protected array $columns;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->columns = [];
    }

    /**
     * Returns all the columns
     *
     * @return array
     */
    public function columns(): array
    {
        return $this->columns;
    }

    /**
     * Add a new column
     *
     * @param  Column|array  $column
     * @return static
     */
    public function addColumn($column): static
    {
        if (\is_array($column)) {
            foreach ($column as $col) {
                $this->_addColum($col);
            }
        } else {
            $this->_addColum($column);
        }

        return $this;
    }

    /**
     * Add column to array
     *
     * @param  Column  $column
     * @return static
     */
    private function _addColum(Column $column): static
    {
        throw_unless(
            $column instanceof Column || $column instanceof ActionColumn,
            InvalidColumn::make($column)
        );

        $this->columns[] = $column;

        return $this;
    }

    /**
     * Generates the columns
     *
     * @return array
     */
    public function generateColumns()
    {
        return collect($this->columns)
                    ->filter(function ($item, $key) {
                        return $item->permission === '' || auth()->user()->roles->first()->hasPermissionTo($item->permission);
                    })
                    ->toArray();
    }

    /**
     * Generates filters
     *
     * @return array
     */
    public function generateFilters()
    {
        return collect($this->columns)
                    ->filter(function ($item, $key) {
                        return $item->is_filtrable();
                    })->map(function ($item) {
                        return [
                            'field' => $item->field(),
                            'filter_key' => $item->filterKey(),
                        ];
                    })
                    ->toArray();
    }

    /**
     * Generate sorts
     *
     * @return array
     */
    public function generateSorts()
    {
        return collect($this->columns)
                    ->filter(function ($item, $key) {
                        return $item->is_sortable();
                    })->map(function ($item) {
                        return $item->field();
                    })
                    ->toArray();
    }
}
