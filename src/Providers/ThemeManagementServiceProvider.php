<?php

namespace Tec\Theme\Providers;

use Tec\Base\Facades\BaseHelper;
use Tec\Base\Supports\Helper;
use Tec\Base\Supports\ServiceProvider;
use Tec\Theme\Facades\Theme;
use Composer\Autoload\ClassLoader;
use Illuminate\Support\Arr;

class ThemeManagementServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $theme = Theme::getThemeName();
        if (! empty($theme)) {
            $this->app['translator']->addJsonPath(theme_path($theme . '/lang'));
            $this->app['translator']->addJsonPath(lang_path('vendor/themes/' . $theme));
        }
    }

    public function boot(): void
    {
        $theme = Theme::getThemeName();

        if (! empty($theme)) {
            $themePath = theme_path($theme);

            $configFilePath = $themePath . '/theme.json';

            if ($this->app['files']->exists($configFilePath)) {
                $content = BaseHelper::getFileData($configFilePath);
                if (!empty($content) && Arr::has($content, 'namespace')) {
                    $loader = new ClassLoader();
                    $loader->setPsr4($content['namespace'], theme_path($theme . '/src'));
                    $loader->register();
                }
            }

            Helper::autoload(theme_path($theme . '/functions'));
<<<<<<< HEAD

            if (file_exists(base_path('themes/'.$theme . '/functions/functions.php'))){
             Helper::autoload(base_path('themes/'.$theme . '/functions'));
              }
=======
            //load child
            $childPath = $this->app->basePath('themes/').$theme;
             if(file_exists($childPath. '/functions/functions.php'))
            Helper::autoload($childPath. '/functions/');
>>>>>>> edf2a723c1757945b0ffd10aaf7c96257895e736
        }
    }
}
