<?php

namespace Tec\Theme\Facades;

use Illuminate\Support\Facades\Facade;
use Tec\Theme\Manager as ManagerSupport;

/**
 * @method static void registerTheme(array|string $theme)
 * @method static array getAllThemes()
 * @method static array getThemes()
 * @deprecated
 * @see \Tec\Theme\Manager
 */
class ManagerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ManagerSupport::class;
    }
}
