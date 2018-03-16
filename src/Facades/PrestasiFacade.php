<?php

namespace Bantenprov\Prestasi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The Prestasi facade.
 *
 * @package Bantenprov\Prestasi
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PrestasiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'prestasi';
    }
}
