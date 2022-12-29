<?php

namespace Advicepharma\Tablegenerator\Elements;

use Advicepharma\Tablegenerator\Contracts\ColumnContract;

class Column implements ColumnContract
{
    /**
     * Database field
     *
     * @var string
     */
    public string $field = '';

    /**
     * Database filter key
     *
     * @var string
     */
    public string $filter_key = '';

    /**
     * Header
     *
     * @var string
     */
    public string $label;

    /**
     * Is filtrable
     *
     * @var bool
     */
    public bool $filtrable;

    /**
     * Is sortable
     *
     * @var bool
     */
    public bool $sortable;

    /**
     * Permission
     *
     * @var string
     */
    public string $permission;

    /**
     * Filter options
     *
     * @var array
     */
    public array $filter_options;

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
    public function __construct()
    {
        $this->sortable = false;
        $this->filtrable = false;
        $this->permission = '';
    }

    /**
     * Get/Set field
     *
     * @param  string|null  $field
     * @return static
     */
    public function field($field = null): static
    {
        if ($field === null) {
            return $this->field;
        } else {
            $this->field = $field;

            if (! $this->filter_key) {
                $this->filter_key = $this->field;
            }

            return $this;
        }
    }

    /**
     * Get/Set filter_key
     *
     * @param  string|null  $filter_key
     * @return static
     */
    public function filterKey($filter_key = null): static
    {
        if ($filter_key === null) {
            return $this->filter_key;
        } else {
            $this->filter_key = $filter_key;

            return $this;
        }
    }

    /**
     * Add filter options
     *
     * @param  array  $options
     * @return static
     */
    public function withOptions(array $options): static
    {
        $this->filter_options = $options;

        return $this;
    }

    /**
     * Get/set label
     *
     * @param  string|null  $label
     * @return static
     */
    public function label($label = null): static
    {
        if ($label === null) {
            return $this->label;
        } else {
            $this->label = $label;

            return $this;
        }
    }

    /**
     * Get if the table is filtrable
     *
     * @return bool
     */
    public function is_filtrable(): static
    {
        return $this->filtrable;
    }

    /**
     * Set the table filtrable
     *
     * @return static
     */
    public function filtrable(): static
    {
        $this->filtrable = true;

        return $this;
    }

    /**
     * Get if the table is sortable
     *
     * @param [type] $filtrable
     * @return static
     */
    public function is_sortable(): static
    {
        return $this->sortable;
    }

    /**
     * Set the table sortable
     *
     * @return static
     */
    public function sortable(): static
    {
        $this->sortable = true;

        return $this;
    }

    /**
     * Set the permission related to this collumn
     *
     * @param  string  $permission
     * @return static
     */
    public function permission($permission): static
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Set column type
     *
     * @param  string  $type
     * @return static
     */
    public function type($type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set column properties
     *
     * @param  array  $properties
     * @return static
     */
    public function properties($properties): static
    {
        $this->properties = $properties;

        return $this;
    }
}
