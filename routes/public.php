<?php

use Tec\Slug\Facades\SlugHelper;
use Tec\Theme\Events\ThemeRoutingAfterEvent;
use Tec\Theme\Events\ThemeRoutingBeforeEvent;
use Tec\Theme\Facades\SiteMapManager;
use Tec\Theme\Facades\Theme;
use Tec\Theme\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Theme::registerRoutes(function () {
    Route::group(['controller' => PublicController::class], function () {
        event(new ThemeRoutingBeforeEvent(app()->make('router')));

        Route::get('/', 'getIndex')->name('public.index');

        Route::get('{key}.{extension}', 'getSiteMapIndex')
            ->where('key', '^' . collect(SiteMapManager::getKeys())->map(fn ($item) => '(?:' . $item . ')')->implode('|') . '$')
            ->whereIn('extension', SiteMapManager::allowedExtensions())
            ->name('public.sitemap.index');

        Route::get('{slug?}', 'getView')->name('public.single');

        Route::get('{prefix}/{slug?}', 'getViewWithPrefix')
            ->whereIn('prefix', SlugHelper::getAllPrefixes() ?: ['1437bcd2-d94e-4a5fd-9a39-b5d60225e9af']);

        event(new ThemeRoutingAfterEvent(app()->make('router')));
    });
});
