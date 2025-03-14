<?php

namespace DeBetooging\Facades;

use Illuminate\Support\Facades\Facade;

class ContactInformation extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'de_betooging.contact_information';
    }
}
