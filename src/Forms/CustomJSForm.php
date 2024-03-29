<?php

namespace Tec\Theme\Forms;

use Tec\Base\Forms\FormAbstract;
use Tec\Base\Models\BaseModel;
use Tec\Theme\Http\Requests\CustomJsRequest;

class CustomJSForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new BaseModel())
            ->setUrl(route('theme.custom-js.post'))
            ->setValidatorClass(CustomJsRequest::class)
            ->add('header_js', 'textarea', [
                'label' => trans('packages/theme::theme.custom_header_js'),
                'value' => setting('custom_header_js'),
                'help_block' => [
                    'text' => trans('packages/theme::theme.custom_header_js_placeholder'),
                ],
                'attr' => [
                    'data-counter' => 2500,
                ],
            ])
            ->add('body_js', 'textarea', [
                'label' => trans('packages/theme::theme.custom_body_js'),
                'value' => setting('custom_body_js'),
                'help_block' => [
                    'text' => trans('packages/theme::theme.custom_body_js_placeholder'),
                ],
                'attr' => [
                    'data-counter' => 2500,
                ],
            ])
            ->add('footer_js', 'textarea', [
                'label' => trans('packages/theme::theme.custom_footer_js'),
                'value' => setting('custom_footer_js'),
                'help_block' => [
                    'text' => trans('packages/theme::theme.custom_footer_js_placeholder'),
                ],
                'attr' => [
                    'data-counter' => 2500,
                ],
            ]);
    }

    public function getActionButtons(): string
    {
        return view('core/base::forms.partials.form-actions', ['onlySave' => true])->render();
    }
}
