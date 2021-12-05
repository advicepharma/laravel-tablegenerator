<?php

namespace Advicepharma\Tablegenerator;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Advicepharma\Tablegenerator\Skeleton\SkeletonClass
 */
class TablegeneratorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tablegenerator';
    }
}
