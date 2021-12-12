<?php

namespace Advicepharma\Tablegenerator\Contracts;

interface CustomColumnContract extends ColumnContract{

    public function addProperty($property, $value);
}
