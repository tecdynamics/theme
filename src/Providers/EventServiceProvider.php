<?php

namespace Tec\Theme\Providers;

use Tec\Base\Events\SeederPrepared;
use Tec\Base\Events\SystemUpdateDBMigrated;
use Tec\Base\Events\SystemUpdatePublished;
use Tec\Theme\Listeners\CoreUpdateThemeDB;
use Tec\Theme\Listeners\PublishThemeAssets;
use Tec\Theme\Listeners\SetDefaultTheme;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SystemUpdateDBMigrated::class => [
            CoreUpdateThemeDB::class,
        ],
        SystemUpdatePublished::class => [
            PublishThemeAssets::class,
        ],
        SeederPrepared::class => [
            SetDefaultTheme::class,
        ],
    ];
}
