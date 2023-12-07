<?php

namespace Tec\Theme\Facades;

use Tec\Theme\Manager as ManagerSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void registerTheme(array|string $theme)
 * @method static array getAllThemes()
 * @method static array getThemes()
 *
 * @see \Tec\Theme\Manager
 */
class Manager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ManagerSupport::class;
    }
}
