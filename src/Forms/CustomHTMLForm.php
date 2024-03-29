<?php

namespace Tec\Theme\Forms;

use Tec\Base\Forms\FormAbstract;
use Tec\Base\Models\BaseModel;
use Tec\Theme\Http\Requests\CustomJsRequest;

class CustomHTMLForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new BaseModel())
            ->setUrl(route('theme.custom-html.post'))
            ->setValidatorClass(CustomJsRequest::class)
            ->add('header_html', 'textarea', [
                'label' => trans('packages/theme::theme.custom_header_html'),
                'value' => setting('custom_header_html'),
                'help_block' => [
                    'text' => trans('packages/theme::theme.custom_header_html_placeholder'),
                ],
                'attr' => [
                    'data-counter' => 2500,
                ],
            ])
            ->add('body_html', 'textarea', [
                'label' => trans('packages/theme::theme.custom_body_html'),
                'value' => setting('custom_body_html'),
                'help_block' => [
                    'text' => trans('packages/theme::theme.custom_body_html_placeholder'),
                ],
                'attr' => [
                    'data-counter' => 2500,
                ],
            ])
            ->add('footer_html', 'textarea', [
                'label' => trans('packages/theme::theme.custom_footer_html'),
                'value' => setting('custom_footer_html'),
                'help_block' => [
                    'text' => trans('packages/theme::theme.custom_footer_html_placeholder'),
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
