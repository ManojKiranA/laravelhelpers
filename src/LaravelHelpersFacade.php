<?php

namespace Manojkiran\LaravelHelpers;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Manojkiran\LaravelHelpers\Skeleton\SkeletonClass
 */
class LaravelHelpersFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelhelpers';
    }
}
