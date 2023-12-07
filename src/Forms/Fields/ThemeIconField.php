<?php

namespace Tec\Theme\Forms\Fields;

use Tec\Base\Facades\Assets;
use Tec\Base\Forms\FormField;

class ThemeIconField extends FormField
{
    protected function getTemplate(): string
    {
        Assets::addScriptsDirectly('vendor/core/packages/theme/js/icons-field.js');

        return 'packages/theme::fields.icons-field';
    }
}
