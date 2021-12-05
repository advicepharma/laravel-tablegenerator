<?php

namespace Advicepharma\Tablegenerator\Exceptions;

use InvalidArgumentException;

class InvalidColumn extends InvalidArgumentException
{
    public static function make($column)
    {
        return new static(
            sprintf(
                'Column %s is invalid.',
                is_object($column)
                    ? sprintf('class `%s`', get_class($column))
                    : sprintf('type `%s`', gettype($column))
            )
        );
    }
}
