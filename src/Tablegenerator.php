<?php

namespace Advicepharma\Tablegenerator;

use App\Http\Resources\UserResource;
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
     * Set the table exportable
     *
     * @var boolean
     */
    protected bool $exportable;

    /**
     * Page size
     *
     * @var int
     */
    protected int $pagesize;

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

    /**
     * Resource to be applied
     *
     * @var string
     */
    protected string $resource = \Advicepharma\Tablegenerator\Resources\GeneralResource::class;

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
     * Add resource object
     *
     * @param string $resource
     * @return Table
     */
    public function withResource(string $resource){
        $this->resource = $resource;
        return $this;
    }

    /**
     * Set the table as pagination
     *
     * @return void
     */
    public function paginate($paginate = true, int $pagesize = 20){
        $this->paginate = $paginate;
        $this->pagesize = $pagesize;
        return $this;
    }

    /**
     * Set the table as pagination
     *
     * @return void
     */
    public function exportable(){
        $this->exportable = true;
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
            $this->query = $this->query->allowedFilters(collect($this->filters)->map(fn($filter) => $filter['filter_key'])->toArray());
        }

        if($this->sort){
            $this->sorts = $this->sorts ?? $this->table->generateSorts();
            $this->query = $this->query->allowedSorts($this->sorts);
        }

        if($this->paginate){
            $this->query = $this->query->paginate($this->pagesize);
        }else{
            $this->query = $this->query->get();
        }

        //dd($this->query);

        return [
            'columns' => $this->table->generateColumns(),
            'data' => $this->resource::collection($this->query)->response()->getData(true)
        ];

    }
}
