<?php

namespace Tec\Theme\ThemeOption\Fields;

use Tec\Theme\Concerns\ThemeOption\Fields\HasOptions;
use Tec\Theme\ThemeOption\ThemeOptionField;

class SelectField extends ThemeOptionField
{
    use HasOptions;

    public function fieldType(): string
    {
        return 'customSelect';
    }

    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'attributes' => [
                ...parent::toArray()['attributes'],
                'choices' => $this->options,
            ],
        ];
    }
}
