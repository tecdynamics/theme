<?php

namespace Tec\Theme\Database\Traits;

use Tec\Setting\Facades\Setting;
use Tec\Theme\Facades\ThemeOption;

trait HasThemeOptionSeeder
{
    protected function truncateOptions(): void
    {
        Setting::newQuery()->where('key', 'LIKE', ThemeOption::getOptionKey('%'))->delete();
    }

    protected function createThemeOptions(array $options, bool $truncate = true): void
    {
        if ($truncate) {
            $this->truncateOptions();
        }

        Setting::set(ThemeOption::prepareFromArray($options));

        Setting::save();
    }
}
