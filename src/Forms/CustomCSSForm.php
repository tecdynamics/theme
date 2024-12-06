<?php

namespace Tec\Theme\Forms;

use Tec\Base\Facades\BaseHelper;
use Tec\Base\Forms\FieldOptions\CodeEditorFieldOption;
use Tec\Base\Forms\Fields\CodeEditorField;
use Tec\Base\Forms\FormAbstract;
use Tec\Theme\Facades\Theme;
use Tec\Theme\Http\Requests\CustomCssRequest;
use Illuminate\Support\Facades\File;

class CustomCSSForm extends FormAbstract
{
    public function setup(): void
    {
        $css = null;
        $file = Theme::getStyleIntegrationPath();

        if (File::exists($file)) {
            $css = BaseHelper::getFileData($file, false);
        }

        $this
            ->setUrl(route('theme.custom-css.post'))
            ->setValidatorClass(CustomCssRequest::class)
            ->setActionButtons(view('core/base::forms.partials.form-actions', ['onlySave' => true])->render())
            ->add(
                'custom_css',
                CodeEditorField::class,
                CodeEditorFieldOption::make()
                    ->label(trans('packages/theme::theme.custom_css'))
                    ->value($css)
                    ->mode('css')
                    ->toArray()
            );
    }
}
