<?php

namespace Skyracer2012\HttpMailDriver;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Skyracer2012\HttpMailDriver\Skeleton\SkeletonClass
 */
class HttpMailDriverFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'http-mail-driver';
    }
}
