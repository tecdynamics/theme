<?php

namespace Tec\Theme\Http\Controllers;

use Tec\Base\Facades\BaseHelper;
use Tec\Base\Http\Controllers\BaseController;
use Tec\Base\Http\Responses\BaseHttpResponse;
use Tec\Page\Models\Page;
use Tec\Page\Services\PageService;
use Tec\SeoHelper\Facades\SeoHelper;
use Tec\Slug\Facades\SlugHelper;
use Tec\Theme\Events\RenderingHomePageEvent;
use Tec\Theme\Events\RenderingSingleEvent;
use Tec\Theme\Events\RenderingSiteMapEvent;
use Tec\Theme\Facades\SiteMapManager;
use Tec\Theme\Facades\Theme;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PublicController extends BaseController
{
    public function getIndex()
    {
        Theme::addBodyAttributes(['id' => 'page-home']);

        if (
            defined('PAGE_MODULE_SCREEN_NAME') &&
            ($homepageId = BaseHelper::getHomepageId()) &&
            ($slug = SlugHelper::getSlug(null, null, Page::class, $homepageId))
        ) {
            $data = (new PageService())->handleFrontRoutes($slug);

            if (! $data) {
                return Theme::scope('index')->render();
            }

            event(new RenderingSingleEvent($slug));

            return Theme::scope($data['view'], $data['data'], $data['default_view'])->render();
        }

        SeoHelper::setTitle(theme_option('site_title'));

        event(RenderingHomePageEvent::class);

        return Theme::scope('index')->render();
    }

    public function getView(?string $key = null, string $prefix = '')
    {
        if (empty($key)) {
            return $this->getIndex();
        }

        $slug = SlugHelper::getSlug($key, $prefix);

			 if (! $slug) {
					$slugData = apply_filters(RENDERING_FILTER_PUBLIC_THEME_SLUG_PAGE, null ,$key, $prefix);
					if(!empty($slugData)){
						 return $slugData;
					}
					abort(404);
			 }

        if (
            defined('PAGE_MODULE_SCREEN_NAME') &&
            $slug->reference_type === Page::class &&
            BaseHelper::isHomepage($slug->reference_id)
        ) {
            return redirect()->to(BaseHelper::getHomepageUrl());
        }

        $result = apply_filters(BASE_FILTER_PUBLIC_SINGLE_DATA, $slug);

        $extension = SlugHelper::getPublicSingleEndingURL();

        if ($extension) {
            $key = Str::replaceLast($extension, '', $key);
        }

        if ($result instanceof BaseHttpResponse) {
            return $result;
        }

        if (isset($result['slug']) && $result['slug'] !== $key) {
            $prefix = SlugHelper::getPrefix(get_class(Arr::first($result['data'])));

            return redirect()->route('public.single', empty($prefix) ? $result['slug'] : "$prefix/{$result['slug']}");
        }

        event(new RenderingSingleEvent($slug));

        if (! empty($result) && is_array($result)) {
            if (isset($result['view'])) {
                Theme::addBodyAttributes(['id' => Str::slug(Str::snake(Str::afterLast($slug->reference_type, '\\'))) . '-' . $slug->reference_id]);

                return Theme::scope($result['view'], $result['data'], Arr::get($result, 'default_view'))->render();
            }

            return $result;
        }

        abort(404);
    }

    public function getSiteMap()
    {
        return $this->getSiteMapIndex();
    }

    public function getSiteMapIndex(string $key = null, string $extension = 'xml')
    {
        if ($key == 'sitemap') {
            $key = null;
        }

        if (! SiteMapManager::init($key, $extension)->isCached()) {
            event(new RenderingSiteMapEvent($key));
        }

        // show your site map (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return SiteMapManager::render($key ? $extension : 'sitemapindex');
    }

    public function getViewWithPrefix(string $prefix, ?string $slug = null)
    {
        return $this->getView($slug, $prefix);
    }
}
