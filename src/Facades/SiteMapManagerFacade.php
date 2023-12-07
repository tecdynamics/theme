<?php

namespace Tec\Theme\Facades;

use Illuminate\Support\Facades\Facade;
use Tec\Theme\Supports\SiteMapManager as SiteMapManagerSupport;

/**
 * @method static \Tec\Theme\Supports\SiteMapManager init(string|null $prefix = null, string $extension = 'xml')
 * @method static \Tec\Theme\Supports\SiteMapManager addSitemap(string $loc, string|null $lastModified = null)
 * @method static string route(string|null $key = null)
 * @method static \Tec\Theme\Supports\SiteMapManager add(string $url, string|null $date = null, string $priority = '1.0', string $sequence = 'daily')
 * @method static bool isCached()
 * @method static \Tec\Sitemap\Sitemap getSiteMap()
 * @method static \Illuminate\Http\Response render(string $type = 'xml')
 * @method static array getKeys()
 * @method static \Tec\Theme\Supports\SiteMapManager registerKey(array|string $key, string|null $value = null)
 * @method static array allowedExtensions()
 * @deprecated
 * @see \Tec\Theme\Supports\SiteMapManager
 */
class SiteMapManagerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SiteMapManagerSupport::class;
    }
}
