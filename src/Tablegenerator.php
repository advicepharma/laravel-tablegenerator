<?php

namespace Advicepharma\Tablegenerator;

use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Advicepharma\Tablegenerator\Elements\Table;
use Illuminate\Database\Eloquent\Relations\Relation;
use Advicepharma\Tablegenerator\Exceptions\InvalidQuery;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Tablegenerator
{

    /**
     * Table object taht contains column
     *
     * @var Table
     */
    protected Table $table;

    /**
     * QueryBuilder object
     *
     * @var QueryBuilder
     */
    protected $query;

    /**
     * If should paginate
     *
     * @var boolean
     */
    protected bool $paginate;

    /**
     * If should show filters
     *
     * @var boolean
     */
    protected bool $filter;

    /**
     * If should sort
     *
     * @var boolean
     */
    protected bool $sort;

    private $filters = null;
    private $sorts = null;

    /**
     * Construct the object
     */
    public function __construct(){
        $this->table = new Table;
        $this->paginate = false;
        $this->filter = false;
        $this->sort = false;
    }

    /**
     * Return the Table object
     *
     * @return void
     */
    public function table(){
        return $this->table;
    }

    /**
     * Set the query
     *
     * @param Object $query
     * @return void
     */
    public function query($query){
        throw_unless(
            $query instanceof QueryBuilder,
            InvalidQuery::make($query)
        );

        $this->query = $query;
        return $this;
    }

    /**
     * Set the table as pagination
     *
     * @return void
     */
    public function paginate(){
        $this->paginate = true;
        return $this;
    }

    /**
     * Add filters
     *
     * @param array|bool $filters
     * @return void
     */
    public function addFilter($filters = null){
        if($filters !== null){
            $this->filters = $filters;
        }

        $this->filter = true;
        return $this;
    }

    /**
     * Ass sort
     *
     * @param array|bool $sorts
     * @return void
     */
    public function addSorts($sorts = null){
        if($sorts !== null){
            $this->sorts = $sorts;
        }

        $this->sort = true;
        return $this;
    }

    /**
     * Generte the structure
     *
     * @return array
     */
    public function generate(){

        if($this->filter){
            $this->filters = $this->filters ?? $this->table->generateFilters();
            $this->query = $this->query->allowedFilters($this->filters);
        }

        if($this->sort){
            $this->sorts = $this->sorts ?? $this->table->generateSorts();
            $this->query = $this->query->allowedSorts($this->sorts);
        }

        if($this->paginate){
            $this->query = $this->query->paginate();
        }

        return [
            'columns' => $this->table->generateColumns(),
            'data' => $this->query
        ];

    }
}
