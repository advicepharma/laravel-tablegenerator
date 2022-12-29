<?php

namespace Advicepharma\Tablegenerator\Contracts;

interface ColumnContract
{
    public function field($field = null);

    public function label($label = null);

    public function filtrable();

    public function sortable();

    public function is_filtrable();

    public function is_sortable();

    public function permission($permission);
}
