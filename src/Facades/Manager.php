<?php

namespace Tec\Theme\Facades;

use Illuminate\Support\Facades\Facade;
use Tec\Theme\Manager as ManagerService;

/**
 * @method static void registerTheme(array|string $theme)
 * @method static array getAllThemes()
 * @method static array getThemes()
 *
 * @see \Tec\Theme\Manager
 */
class Manager extends Facade
{

    /**
     * @return string
     *
     * @since 2.1
     */
    protected static function getFacadeAccessor()
    {
        return ManagerService::class;
    }
}
