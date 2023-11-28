<?php

namespace Tec\Theme\Facades;

use Illuminate\Support\Facades\Facade;
use Tec\Theme\Supports\AdminBar as AdminBarService;
/**
* @method static bool isDisplay()
* @method static \Tec\Theme\Supports\AdminBar setIsDisplay(bool $isDisplay = true)
 * @method static array getGroups()
    * @method static array getLinksNoGroup()
    * @method static \Tec\Theme\Supports\AdminBar registerGroup(string $slug, string $title, string $link = 'javascript:;')
 * @method static \Tec\Theme\Supports\AdminBar registerLink(string $title, string $url, $group = null, string|null $permission = null)
 * @method static string render()
*
 * @see \Tec\Theme\Supports\AdminBar
*/
class AdminBar extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AdminBarService::class;
    }
}
