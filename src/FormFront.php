<?php

namespace Tec\Theme;

use Tec\Base\Forms\FieldOptions\HtmlFieldOption;
use Tec\Base\Forms\Fields\HtmlField;
use Tec\Base\Forms\FormAbstract;
use Illuminate\Support\Str;

abstract class FormFront extends FormAbstract
{
    public static function formTitle(): string
    {
        return Str::title(Str::snake(class_basename(static::class), ' '));
    }

    public function buildForm(): void
    {
        $this->add(
            'form_front_form_start',
            HtmlField::class,
            HtmlFieldOption::make()
                ->content(apply_filters('form_front_form_start', '', $this))
                ->toArray()
        );

        parent::buildForm();

        $this->add(
            'form_front_form_end',
            HtmlField::class,
            HtmlFieldOption::make()
                ->content(apply_filters('form_front_form_end', '', $this))
                ->toArray()
        );

        $this->addBefore(
            'submit',
            'form_front_before_submit_button',
            HtmlField::class,
            HtmlFieldOption::make()
                ->content(apply_filters('form_front_before_submit_button', '', $this))
                ->toArray()
        );
    }
}
