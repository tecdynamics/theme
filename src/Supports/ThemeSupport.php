<?php

namespace Tec\Theme\Supports;

use Tec\Base\Facades\Html;
use Illuminate\Support\Str;

class ThemeSupport
{
    public static function registerYoutubeShortcode(string $viewPath = null): void
    {
        add_shortcode(
            'youtube-video',
            __('YouTube video'),
            __('Add YouTube video'),
            function ($shortcode) use ($viewPath) {
                $url = Youtube::getYoutubeVideoEmbedURL($shortcode->content);

                $width = $shortcode->width;
                $height = $shortcode->height;

                return view(($viewPath ?: 'packages/theme::shortcodes') . '.youtube', compact('url', 'width', 'height'))
                    ->render();
            }
        );

        shortcode()->setAdminConfig('youtube-video', function ($attributes, $content) use ($viewPath) {
            return view(($viewPath ?: 'packages/theme::shortcodes') . '.youtube-admin-config', compact('attributes', 'content'))->render();
        });
    }

    public static function registerGoogleMapsShortcode(string $viewPath = null): void
    {
        add_shortcode('google-map', __('Google map'), __('Add Google map iframe'), function ($shortcode) use ($viewPath) {
            return view(($viewPath ?: 'packages/theme::shortcodes') . '.google-map', ['address' => $shortcode->content])
                ->render();
        });

        shortcode()->setAdminConfig('google-map', function ($attributes, $content) use ($viewPath) {
            return view(($viewPath ?: 'packages/theme::shortcodes') . '.google-map-admin-config', compact('attributes', 'content'))->render();
        });
    }

<<<<<<< HEAD
    public static function getCustomJS(string $location): string
=======
    /**
     * @param string $location
     * @return string
     */
    public static function getCustomJS(string $location)
>>>>>>> edf2a723c1757945b0ffd10aaf7c96257895e736
    {
        $js = setting('custom_' . $location . '_js');

        if (empty($js)) {
            return '';
        }

<<<<<<< HEAD
        if ((! Str::contains($js, '<script') || ! Str::contains($js, '</script>')) && ! Str::contains($js, '<noscript') && ! Str::contains($js, '</noscript>')) {
=======
        if (!Str::contains($js, '<script') || !Str::contains($js, '</script>')) {
>>>>>>> edf2a723c1757945b0ffd10aaf7c96257895e736
            $js = Html::tag('script', $js);
        }

        return $js;
    }

    public static function getCustomHtml(string $location): string
    {
        $html = setting('custom_' . $location . '_html');

        if (empty($html)) {
            return '';
        }

        return $html;
    }

    public static function insertBlockAfterTopHtmlTags(string|null $block, string|null $html): string|null
    {
        if (! $block || ! $html) {
            return $html;
        }

        preg_match_all('/^<([a-z]+)([^>]+)*(?:>(.*)<\/\1>|\s+\/>)$/sm', $html, $matches);

        if (empty($matches[0])) {
            return $html;
        }

        $parsedHtml = '';

        foreach ($matches[0] as $blockItem) {
            $parsedHtml .= Str::replaceLast('</', $block . '</', $blockItem);
        }

        return $parsedHtml;
    }
}
