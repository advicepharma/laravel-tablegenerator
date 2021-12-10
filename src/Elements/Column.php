<?php

namespace Advicepharma\Tablegenerator\Elements;

use Advicepharma\Tablegenerator\Contracts;
use Advicepharma\Tablegenerator\Contracts\ColumnContract;

class Column implements ColumnContract{

    /**
     * Database field
     *
     * @var string
     */
    public string $field;

    /**
     * Header
     *
     * @var string
     */
    public string $label;

    /**
     * Is filtrable
     *
     * @var boolean
     */
    public bool $filtrable;

    /**
     * Is sortable
     *
     * @var boolean
     */
    public bool $sortable;

    public function __construct(){
        $this->sortable = false;
        $this->filtrable = false;
    }

    /**
     * Get/Set field
     *
     * @param string|null $field
     * @return Column
     */
    public function field($field = null){
        if($field === null){
            return $this->field;
        }else{
            $this->field = $field;
            return $this;
        }
    }

    /**
     * Get/set label
     *
     * @param string|null $label
     * @return Column
     */
    public function label($label = null){
        if($label === null){
            return $this->label;
        }else{
            $this->label = $label;
            return $this;
        }
    }

    /**
     * Get if the table is filtrable
     *
     * @return boolean
     */
    public function is_filtrable(){
        return $this->filtrable;
    }

    /**
     * Set the table filtrable
     *
     * @return Column
     */
    public function filtrable(){
        $this->filtrable = true;
        return $this;
    }

    /**
     * Get if the table is sortable
     *
     * @param [type] $filtrable
     * @return Column
    */
    public function is_sortable(){
        return $this->sortable;
    }

    /**
     * Set the table sortable
     *
     * @return Column
     */
    public function sortable(){
        $this->sortable = true;
        return $this;
    }

}
