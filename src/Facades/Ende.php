<?php

namespace Azzarip\Ende\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Azzarip\Ende\Ende
 */
class Ende extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Azzarip\Ende\Ende::class;
    }
}
