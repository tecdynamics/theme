<?php

namespace Tec\Theme\Listeners;

use Tec\Theme\Facades\Theme;
use Tec\Theme\Services\ThemeService;
use Illuminate\Support\Facades\File;

class PublishThemeAssets
{
    public function handle(): void
    {
        File::delete(theme_path(Theme::getThemeName() . '/public/css/style.integration.css'));

        $customCSS = Theme::getStyleIntegrationPath();

        if (File::exists($customCSS)) {
            File::copy($customCSS, storage_path('app/style.integration.css.') . time());
        }

        app(ThemeService::class)->publishAssets();
    }
}
