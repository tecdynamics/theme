<?php

namespace Tec\Theme\ThemeOption\Fields;

use Tec\Theme\ThemeOption\ThemeOptionField;

class ToggleField extends ThemeOptionField
{
    public function fieldType(): string
    {
        return 'onOff';
    }

    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'attributes' => [
                ...parent::toArray()['attributes'],
                'value' => $this->getValue(),
            ],
        ];
    }
}
