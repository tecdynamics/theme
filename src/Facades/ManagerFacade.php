<?php

namespace Tec\Theme\Facades;

use Tec\Theme\Manager;
use Illuminate\Support\Facades\Facade;
/**
 * @method static void registerTheme(array|string $theme)
 * @method static array getAllThemes()
 * @method static array getThemes()
 *
 * @see \Tec\Theme\Manager
 */
class ManagerFacade extends Facade
{

    /**
     * @return string
     *
     * @since 2.1
     */
    protected static function getFacadeAccessor()
    {
        return Manager::class;
    }
}
