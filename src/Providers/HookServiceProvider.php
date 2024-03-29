<?php

namespace Tec\Theme\Providers;

use Tec\Base\Facades\BaseHelper;
use Tec\Base\Facades\Html;
use Tec\Base\Supports\ServiceProvider;
use Tec\Dashboard\Supports\DashboardWidgetInstance;
use Tec\Page\Models\Page;
use Tec\Shortcode\Compilers\Shortcode;
use Tec\Shortcode\Compilers\ShortcodeCompiler;
use Tec\Theme\Facades\AdminBar;
use Tec\Theme\Facades\Theme;
use Tec\Theme\Supports\ThemeSupport;
use Tec\Theme\Supports\Vimeo;
use Tec\Theme\Supports\Youtube;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(PAGE_FILTER_PAGE_NAME_IN_ADMIN_LIST, function (string $name, Page $page) {
            if (BaseHelper::isHomepage($page->getKey())) {
                $name .= Html::tag('span', ' — ' . trans('packages/page::pages.front_page'), [
                    'class' => 'additional-page-name',
                ])->toHtml();
            }

            return $name;
        }, 10, 2);

        add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'addStatsWidgets'], 4, 2);

        add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSetting'], 39);

        add_filter('get_http_exception_view', function (string $defaultView, HttpExceptionInterface $exception) {
            if (view()->exists($view = Theme::getThemeNamespace('views.' . $exception->getStatusCode()))) {
                return $view;
            }

            return $defaultView;
        }, 10, 2);

        theme_option()
            ->setSection([
                'title' => trans('packages/theme::theme.theme_option_general'),
                'desc' => trans('packages/theme::theme.theme_option_general_description'),
                'priority' => 0,
                'id' => 'opt-text-subsection-general',
                'subsection' => true,
                'icon' => 'fa fa-home',
                'fields' => [
                    [
                        'id' => 'site_title',
                        'type' => 'text',
                        'label' => trans('core/setting::setting.general.site_title'),
                        'attributes' => [
                            'name' => 'site_title',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => trans('core/setting::setting.general.site_title'),
                                'data-counter' => 255,
                            ],
                        ],
                    ],
                    [
                        'id' => 'show_site_name',
                        'section_id' => 'opt-text-subsection-general',
                        'type' => 'customSelect',
                        'label' => trans('core/setting::setting.general.show_site_name'),
                        'attributes' => [
                            'name' => 'show_site_name',
                            'list' => [
                                '0' => __('No'),
                                '1' => __('Yes'),
                            ],
                            'value' => '0',
                        ],
                    ],
                    [
                        'id' => 'seo_title',
                        'type' => 'text',
                        'label' => trans('core/setting::setting.general.seo_title'),
                        'attributes' => [
                            'name' => 'seo_title',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => trans('core/setting::setting.general.seo_title'),
                                'data-counter' => 120,
                            ],
                        ],
                    ],
                    [
                        'id' => 'seo_description',
                        'type' => 'textarea',
                        'label' => trans('core/setting::setting.general.seo_description'),
                        'attributes' => [
                            'name' => 'seo_description',
                            'value' => null,
                            'options' => [
                                'class' => 'form-control',
                                'rows' => 4,
                            ],
                        ],
                    ],
                    [
                        'id' => 'seo_og_image',
                        'type' => 'mediaImage',
                        'label' => trans('packages/theme::theme.theme_option_seo_open_graph_image'),
                        'attributes' => [
                            'name' => 'seo_og_image',
                            'value' => null,
                        ],
                    ],
                    [
                        'id' => 'theme_breadcrumb_enabled',
                        'section_id' => 'opt-text-subsection-general',
                        'type' => 'customSelect',
                        'label' => trans('packages/theme::theme.breadcrumb_enabled'),
                        'attributes' => [
                            'name' => 'theme_breadcrumb_enabled',
                            'list' => [
                                '1' => __('Yes'),
                                '0' => __('No'),
                            ],
                            'value' => '1',
                        ],
                    ],
                ],
            ])
            ->setSection([
                'title' => trans('packages/theme::theme.theme_option_logo'),
                'desc' => trans('packages/theme::theme.theme_option_logo'),
                'priority' => 0,
                'id' => 'opt-text-subsection-logo',
                'subsection' => true,
                'icon' => 'fa fa-image',
                'fields' => [
                    [
                        'id' => 'favicon',
                        'type' => 'mediaImage',
                        'label' => trans('packages/theme::theme.theme_option_favicon'),
                        'attributes' => [
                            'name' => 'favicon',
                            'value' => null,
                            'attributes' => ['allow_thumb' => false],
                        ],
                    ],
                    [
                        'id' => 'logo',
                        'type' => 'mediaImage',
                        'label' => trans('packages/theme::theme.theme_option_logo'),
                        'attributes' => [
                            'name' => 'logo',
                            'value' => null,
                            'attributes' => ['allow_thumb' => false],
                        ],
                    ],
                ],
            ]);

        add_shortcode('media', 'Media', 'Media', function (Shortcode $shortcode) {
            $url = $shortcode->url;

            if (! $url) {
                return null;
            }

            $url = rtrim($url, '/');

            if (! $url) {
                return null;
            }

            $iframe = null;

            $data = [
                'class' => 'embed-responsive-item',
                'height' => 315,
                'width' => 420,
            ];

            if ($shortcode->width) {
                $data['width'] = $shortcode->width;
            }

            if ($shortcode->height) {
                $data['height'] = $shortcode->height;
            }

            if (Youtube::isYoutubeURL($url)) {
                $data['allowfullscreen'] = true;
                $data['frameborder'] = 0;

                $data['src'] = Youtube::getYoutubeVideoEmbedURL($url);

                $iframe = Html::tag('iframe', '', $data)->toHtml();
            } elseif (Vimeo::isVimeoURL($url)) {
                $videoId = Vimeo::getVimeoID($url);
                if ($videoId) {
                    $data['allow'] = 'autoplay; fullscreen; picture-in-picture';
                    $data['src'] = 'https://player.vimeo.com/video/' . $videoId;

                    $iframe = Html::tag('iframe', '', $data)->toHtml();
                }
            }

            if ($iframe) {
                return Html::tag('div', $iframe, ['class' => 'embed-responsive embed-responsive-16by9 mb30'])
                    ->toHtml();
            }

            return null;
        });

        shortcode()->setAdminConfig('media', function (array $attributes) {
            return view('packages/theme::shortcodes.media-admin-config', compact('attributes'))->render();
        });

        add_filter(THEME_FRONT_HEADER, function (string|null $html): string|null {
            $file = Theme::getStyleIntegrationPath();
            if ($this->app['files']->exists($file)) {
                $html .= PHP_EOL . Html::style(Theme::asset()->url('css/style.integration.css?v=' . filectime($file)));
            }

            return $html;
        }, 15);

        if (! BaseHelper::hasDemoModeEnabled()) {
            if (config('packages.theme.general.enable_custom_html_shortcode')) {
                add_shortcode('custom-html', __('Custom HTML'), __('Add custom HTML content'), function (Shortcode $shortcode) {
                    return html_entity_decode($shortcode->getContent());
                });

                shortcode()->setAdminConfig('custom-html', function (array $attributes, string|null $content) {
                    return view('packages/theme::shortcodes.custom-html-admin-config', compact('attributes', 'content'))
                        ->render();
                });
            }

            if (config('packages.theme.general.enable_custom_js')) {
                if (setting('custom_header_js')) {
                    add_filter(THEME_FRONT_HEADER, function (string|null $html): string {
                        return $html . ThemeSupport::getCustomJS('header');
                    }, 15);
                }

                if (setting('custom_body_js')) {
                    add_filter(THEME_FRONT_BODY, function (string|null $html): string {
                        return $html . ThemeSupport::getCustomJS('body');
                    }, 15);
                }

                if (setting('custom_footer_js')) {
                    add_filter(THEME_FRONT_FOOTER, function (string|null $html): string {
                        return $html . ThemeSupport::getCustomJS('footer');
                    }, 15);
                }
            }

            if (config('packages.theme.general.enable_custom_html')) {
                if (setting('custom_header_html')) {
                    add_filter(THEME_FRONT_HEADER, function (string|null $html): string {
                        return $html . ThemeSupport::getCustomHtml('header');
                    }, 16);
                }

                if (setting('custom_body_html')) {
                    add_filter(THEME_FRONT_BODY, function (string|null $html): string {
                        return $html . ThemeSupport::getCustomHtml('body');
                    }, 16);
                }

                if (setting('custom_footer_html')) {
                    add_filter(THEME_FRONT_FOOTER, function (string|null $html): string {
                        return $html . ThemeSupport::getCustomHtml('footer');
                    }, 16);
                }
            }
        }

        add_filter(THEME_FRONT_FOOTER, function (string|null $html): string|null {
            try {
                if (! Auth::guard()->check() || ! AdminBar::isDisplay() || ! (int)setting('show_admin_bar', 1)) {
                    return $html;
                }

                return $html . Html::style('vendor/core/packages/theme/css/admin-bar.css') . AdminBar::render();
            } catch (Throwable) {
                return $html;
            }
        }, 14);

        add_filter(
            'shortcode_content_compiled',
            function (string|null $html, string $name, $callback, ShortcodeCompiler $compiler) {
                $editLink = $compiler->getEditLink();

                if (! $editLink || ! setting('show_theme_guideline_link', false)) {
                    return $html;
                }

                Theme::asset()
                    ->usePath(false)
                    ->add('theme-guideline-css', asset('vendor/core/packages/theme/css/guideline.css'));

                $link = view('packages/theme::guideline-link', [
                    'html' => $html,
                    'editLink' => $editLink . '?shortcode=' . $compiler->getName(),
                    'editLabel' => __('Edit this shortcode'),
                ])->render();

                return ThemeSupport::insertBlockAfterTopHtmlTags($link, $html);
            },
            9999,
            4
        );

        add_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, function () {
            if (BaseHelper::getRichEditor() === 'ckeditor') {
                Theme::asset()
                    ->add('ckeditor-content-styles', 'vendor/core/core/base/libraries/ckeditor/content-styles.css');
            }
        }, 15);

        add_filter('cms_settings_validation_rules', [$this, 'addSettingRules'], 15);
    }

    public function addSettingRules(array $rules): array
    {
        return array_merge($rules, [
            'enable_cache_site_map' => 'nullable|in:0,1',
            'cache_time_site_map' => 'nullable|integer|min:0',
            'show_admin_bar' => 'nullable|in:0,1',
            'redirect_404_to_homepage' => 'nullable|in:0,1',
            'show_theme_guideline_link' => 'nullable|in:0,1',
        ]);
    }

    public function addStatsWidgets(array $widgets, Collection $widgetSettings): array
    {
        $themes = count(BaseHelper::scanFolder(theme_path()));

        return (new DashboardWidgetInstance())
            ->setType('stats')
            ->setPermission('theme.index')
            ->setTitle(trans('packages/theme::theme.theme'))
            ->setKey('widget_total_themes')
            ->setIcon('fa fa-paint-brush')
            ->setColor('#e7505a')
            ->setStatsTotal($themes)
            ->setRoute(route('theme.index'))
            ->init($widgets, $widgetSettings);
    }

    public function addSetting(string|null $data = null): string
    {
        return $data . view('packages/theme::setting')->render();
    }
}
