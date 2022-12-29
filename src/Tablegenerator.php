<?php

namespace Advicepharma\Tablegenerator;

use Advicepharma\Tablegenerator\Elements\Table;
use Advicepharma\Tablegenerator\Exceptions\InvalidQuery;
use Spatie\QueryBuilder\QueryBuilder;

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
     * @var bool
     */
    protected bool $paginate;

    /**
     * Set the table exportable
     *
     * @var bool
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
     * @var bool
     */
    protected bool $filter;

    /**
     * If should sort
     *
     * @var bool
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
    public function __construct()
    {
        $this->table = new Table;
        $this->paginate = false;
        $this->filter = false;
        $this->sort = false;
    }

    /**
     * Return the Table object
     *
     * @return Table
     */
    public function table(): Table
    {
        return $this->table;
    }

    /**
     * Set the query
     *
     * @param  object  $query
     * @return Tablegenerator
     */
    public function query(object $query): Tablegenerator
    {
        throw_unless(
            $query instanceof QueryBuilder, /** @phpstan-ignore-line */
            InvalidQuery::make($query)
        );

        $this->query = $query;

        return $this;
    }

    /**
     * Add resource object
     *
     * @param  string  $resource
     * @return static
     */
    public function withResource(string $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Set the table as pagination
     *
     * @param  bool  $paginate
     * @param  int  $pagesize
     * @return static
     */
    public function paginate(bool $paginate = true, int $pagesize = 20): static
    {
        $this->paginate = $paginate;
        $this->pagesize = $pagesize;

        return $this;
    }

    /**
     * Set the table as pagination
     *
     * @return static
     */
    public function exportable(): static
    {
        $this->exportable = true;

        return $this;
    }

    /**
     * Add filters
     *
     * @param  array|bool  $filters
     * @return static
     */
    public function addFilter(array|bool $filters = null): static
    {
        if ($filters !== null) {
            $this->filters = $filters;
        }

        $this->filter = true;

        return $this;
    }

    /**
     * Ass sort
     *
     * @param  array|bool  $sorts
     * @return static
     */
    public function addSorts(array|bool $sorts = null): static
    {
        if ($sorts !== null) {
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
    public function generate(): array
    {
        if ($this->filter) {
            $this->filters = $this->filters ?? $this->table->generateFilters();
            $this->query = $this->query->allowedFilters(collect($this->filters)->map(fn ($filter) => $filter['filter_key'])->toArray());
        }

        if ($this->sort) {
            $this->sorts = $this->sorts ?? $this->table->generateSorts();
            $this->query = $this->query->allowedSorts($this->sorts);
        }

        if ($this->paginate) {
            $this->query = $this->query->paginate($this->pagesize);
        } else {
            $this->query = $this->query->get();
        }

        //dd($this->query);

        return [
            'columns' => $this->table->generateColumns(),
            'data' => $this->resource::collection($this->query)->response()->getData(true),
        ];
    }
}
