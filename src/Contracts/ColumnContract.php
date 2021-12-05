<?php

namespace Advicepharma\Tablegenerator\Contracts;

interface ColumnContract{

    public function field($field = null);
    public function label($label = null);
    public function filtrable($filtrable = null);
    public function sortable($sortable = null);
    public function is_filtrable();
    public function is_sortable();
}
