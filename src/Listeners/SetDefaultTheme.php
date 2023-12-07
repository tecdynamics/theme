<?php

namespace Tec\Theme\Listeners;

use Tec\Setting\Facades\Setting;
use Tec\Theme\Facades\Theme;

class SetDefaultTheme
{
    public function handle(): void
    {
        Setting::forceSet('theme', Theme::getThemeName())->set('show_admin_bar', 1)->save();
    }
}
