<?php

namespace DeBetooging\Facades;

use Illuminate\Support\Facades\Facade;

class SocialMedia extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'de_betooging.social_media';
    }
}
