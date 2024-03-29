<?php

namespace Tec\Theme\Forms;

use Tec\Base\Facades\BaseHelper;
use Tec\Base\Forms\FormAbstract;
use Tec\Base\Models\BaseModel;
use Tec\Theme\Facades\Theme;
use Tec\Theme\Http\Requests\CustomCssRequest;
use Illuminate\Support\Facades\File;

class CustomCSSForm extends FormAbstract
{
    public function buildForm(): void
    {
        $css = null;
        $file = Theme::getStyleIntegrationPath();
        if (File::exists($file)) {
            $css = BaseHelper::getFileData($file, false);
        }

        $this
            ->setupModel(new BaseModel())
            ->setUrl(route('theme.custom-css.post'))
            ->setValidatorClass(CustomCssRequest::class)
            ->add('custom_css', 'textarea', [
                'label' => trans('packages/theme::theme.custom_css'),
                'value' => $css,
                'help_block' => [
                    'text' => trans('packages/theme::theme.custom_css_placeholder'),
                ],
            ]);
    }

    public function getActionButtons(): string
    {
        return view('core/base::forms.partials.form-actions', ['onlySave' => true])->render();
    }
}
