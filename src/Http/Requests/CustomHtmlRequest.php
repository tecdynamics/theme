<?php

namespace Tec\Theme\Http\Requests;

use Tec\Support\Http\Requests\Request;

class CustomHtmlRequest extends Request
{
    public function rules(): array
    {
        return [
            'header_html' => 'nullable|string',
            'body_html' => 'nullable|string',
            'footer_html' => 'nullable|string',
        ];
    }
}
