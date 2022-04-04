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
    public string $field = "";

    /**
     * Database filter key
     *
     * @var string
     */
    public string $filter_key = "";

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

    /**
     * Permission
     *
     * @var string
     */
    public string $permission;

    /**
     * Column Type
     *
     * @var string
     */
    public $type = '';

    /**
     * Column Properties
     *
     * @var array
     */
    public $properties = [];

    /**
     * Constructor
     */
    public function __construct(){
        $this->sortable = false;
        $this->filtrable = false;
        $this->permission = "";
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

            if(!$this->filter_key){
                $this->filter_key = $this->field;
            }
            return $this;
        }
    }

    /**
     * Get/Set filter_key
     *
     * @param string|null $filter_key
     * @return Column
     */
    public function filterKey($filter_key = null){
        if($filter_key === null){
            return $this->filter_key;
        }else{
            $this->filter_key = $filter_key;
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

    /**
     * Set the permission related to this collumn
     *
     * @param string $permission
     * @return Column
     */
    public function permission($permission){
        $this->permission = $permission;
        return $this;
    }

    /**
     * Set column type
     *
     * @param string $type
     * @return Column
     */
    public function type($type){
        $this->type = $type;
        return $this;
    }

    /**
     * Set column properties
     *
     * @param array $properties
     * @return Column
     */
    public function properties($properties){
        $this->properties = $properties;
        return $this;
    }

}
