<?php

namespace Tec\Theme\Forms;

use Tec\Base\Facades\Html;
use Tec\Base\Forms\FieldOptions\AlertFieldOption;
use Tec\Base\Forms\FieldOptions\CodeEditorFieldOption;
use Tec\Base\Forms\Fields\AlertField;
use Tec\Base\Forms\Fields\CodeEditorField;
use Tec\Base\Forms\FormAbstract;
use Tec\Theme\Http\Requests\RobotsTxtRequest;
use Illuminate\Support\Facades\File;

class RobotsTxtEditorForm extends FormAbstract
{
    public function setup(): void
    {
        $isRobotsTxtWritable = File::isWritable($path = public_path('robots.txt'));
        $robotsTxtContent = $isRobotsTxtWritable && File::exists($path) ? File::get($path) : '';

        $this
            ->setUrl(route('theme.robots-txt.post'))
            ->setValidatorClass(RobotsTxtRequest::class)
            ->setActionButtons(view('core/base::forms.partials.form-actions', ['onlySave' => true])->render())
            ->when(! $isRobotsTxtWritable, function (FormAbstract $form) use ($path) {
                $form->add(
                    'robots_txt_not_writable',
                    AlertField::class,
                    AlertFieldOption::make()
                        ->type('warning')
                        ->content(trans('packages/theme::theme.robots_txt_not_writable', ['path' => $path]))
                        ->toArray()
                );
            })
            ->add(
                'robots_txt_content',
                CodeEditorField::class,
                CodeEditorFieldOption::make()
                    ->label(trans('packages/theme::theme.robots_txt_content'))
                    ->value($robotsTxtContent)
                    ->maxLength(2500)
                    ->helperText(
                        trans(
                            'packages/theme::theme.robots_txt_content_helper',
                            ['link' => Html::link(url('robots.txt'), attributes: ['target' => '_blank'])]
                        )
                    )
                    ->toArray()
            )
            ->add(
                'robots_txt_file',
                'file',
                [
                    'label' => trans('packages/theme::theme.robots_txt_file'),
                    'help_block' => [
                        'text' => trans('packages/theme::theme.robots_txt_file_helper'),
                    ],
                ]
            );
        ;
    }
}
