<?php

namespace Tec\Theme\Http\Requests;

use Tec\Support\Http\Requests\Request;

class CustomHtmlRequest extends Request
{
    public function rules(): array
    {
        return [
            'custom_header_html' => 'nullable|string|max:2500',
            'custom_body_html' => 'nullable|string|max:2500',
            'custom_footer_html' => 'nullable|string|max:2500',
        ];
    }
}
