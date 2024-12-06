<?php

namespace Tec\Theme\ThemeOption\Fields;

use Tec\Theme\Concerns\ThemeOption\Fields\HasOptions;
use Tec\Theme\ThemeOption\ThemeOptionField;

class RadioField extends ThemeOptionField
{
    use HasOptions;

    protected bool $inline = true;

    public function inline(bool $inline): static
    {
        $this->inline = $inline;

        return $this;
    }

    public function fieldType(): string
    {
        return 'customRadio';
    }

    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'attributes' => [
                ...parent::toArray()['attributes'],
                'choices' => $this->options,
                'selected' => $this->getValue(),
                'attr' => [
                    'inline' => $this->inline,
                ],
            ],
        ];
    }
}
