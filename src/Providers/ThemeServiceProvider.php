<?php

namespace Tec\Theme\Providers;

use Tec\Base\Facades\DashboardMenu;
use Tec\Base\Supports\DashboardMenu as DashboardMenuSupport;
use Tec\Base\Supports\ServiceProvider;
use Tec\Base\Traits\LoadAndPublishDataTrait;
use Tec\Theme\Commands\ThemeActivateCommand;
use Tec\Theme\Commands\ThemeAssetsPublishCommand;
use Tec\Theme\Commands\ThemeAssetsRemoveCommand;
use Tec\Theme\Commands\ThemeOptionCheckMissingCommand;
use Tec\Theme\Commands\ThemeRemoveCommand;
use Tec\Theme\Commands\ThemeRenameCommand;
use Tec\Theme\Contracts\Theme as ThemeContract;
use Tec\Theme\Theme;
use Illuminate\Routing\Events\RouteMatched;

class ThemeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->setNamespace('packages/theme')
            ->loadHelpers();

        $this->app->bind(ThemeContract::class, Theme::class);

        $this->commands([
            ThemeActivateCommand::class,
            ThemeRemoveCommand::class,
            ThemeAssetsPublishCommand::class,
            ThemeOptionCheckMissingCommand::class,
            ThemeAssetsRemoveCommand::class,
            ThemeRenameCommand::class,
        ]);
    }

    public function boot(): void
    {
        $this
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->publishAssets();

        $this->app['events']->listen(RouteMatched::class, function () {
            $config = $this->app['config'];

            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-core-appearance',
                    'priority' => 996,
                    'parent_id' => null,
                    'name' => 'packages/theme::theme.appearance',
                    'icon' => 'fa fa-paint-brush',
                    'url' => '#',
                    'permissions' => [],
                ])
                ->when(
                    $config->get('packages.theme.general.display_theme_manager_in_admin_panel', true),
                    function (DashboardMenuSupport $menu) {
                        $menu->registerItem([
                            'id' => 'cms-core-theme',
                            'priority' => 1,
                            'parent_id' => 'cms-core-appearance',
                            'name' => 'packages/theme::theme.name',
                            'icon' => null,
                            'url' => route('theme.index'),
                            'permissions' => ['theme.index'],
                        ]);
                    }
                )
                ->registerItem([
                    'id' => 'cms-core-theme-option',
                    'priority' => 4,
                    'parent_id' => 'cms-core-appearance',
                    'name' => 'packages/theme::theme.theme_options',
                    'icon' => null,
                    'url' => route('theme.options'),
                    'permissions' => ['theme.options'],
                ])
                ->registerItem([
                    'id' => 'cms-core-appearance-custom-css',
                    'priority' => 5,
                    'parent_id' => 'cms-core-appearance',
                    'name' => 'packages/theme::theme.custom_css',
                    'icon' => null,
                    'url' => route('theme.custom-css'),
                    'permissions' => ['theme.custom-css'],
                ])
                ->when(
                    $config->get('packages.theme.general.enable_custom_js'),
                    function (DashboardMenuSupport $menu) {
                        $menu->registerItem([
                            'id' => 'cms-core-appearance-custom-js',
                            'priority' => 6,
                            'parent_id' => 'cms-core-appearance',
                            'name' => 'packages/theme::theme.custom_js',
                            'icon' => null,
                            'url' => route('theme.custom-js'),
                            'permissions' => ['theme.custom-js'],
                        ]);
                    }
                )
                ->when(
                    $config->get('packages.theme.general.enable_custom_html'),
                    function (DashboardMenuSupport $menu) {
                        $menu->registerItem([
                            'id' => 'cms-core-appearance-custom-html',
                            'priority' => 6,
                            'parent_id' => 'cms-core-appearance',
                            'name' => 'packages/theme::theme.custom_html',
                            'icon' => null,
                            'url' => route('theme.custom-html'),
                            'permissions' => ['theme.custom-html'],
                        ]);
                    }
                );

            admin_bar()
                ->registerLink(trans('packages/theme::theme.name'), route('theme.index'), 'appearance', 'theme.index')
                ->registerLink(
                    trans('packages/theme::theme.theme_options'),
                    route('theme.options'),
                    'appearance',
                    'theme.options'
                );
        });

        $this->app->booted(function () {

            $this->app->register(HookServiceProvider::class);
        });

        $this->app->register(ThemeManagementServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }
}
