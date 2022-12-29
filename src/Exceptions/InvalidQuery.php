<?php

namespace Advicepharma\Tablegenerator\Exceptions;

use InvalidArgumentException;

final class InvalidQuery extends InvalidArgumentException
{
    public static function make($query)
    {
        return new static(
            sprintf(
                'Query %s is invalid.',
                is_object($query)
                    ? sprintf('class `%s`', get_class($query))
                    : sprintf('type `%s`', gettype($query))
            )
        );
    }
}
