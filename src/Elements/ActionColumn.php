<?php

namespace Advicepharma\Tablegenerator\Elements;

use Advicepharma\Tablegenerator\Contracts\ColumnContract;

class ActionColumn extends Column implements ColumnContract
{
    /**
     * List of actions
     *
     * @var array
     */
    public array $actions;

    /**
     * Type of Column
     *
     * @var string
     */
    //public string $type = 'actions';

    public function __construct()
    {
        parent::__construct();
        $this->actions = [];
        $this->type = 'actions';
    }

    /**
     * Add actions
     *
     * @param [type] $action
     * @return ActionColumn
     */
    public function addAction($action)
    {
        if ($action !== null) {
            $this->actions[] = $action;
        }

        return $this;
    }
}
