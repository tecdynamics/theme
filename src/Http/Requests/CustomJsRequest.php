<?php

namespace Tec\Theme\Http\Requests;

use Tec\Support\Http\Requests\Request;

class CustomJsRequest extends Request
{
    public function rules(): array
    {
        return [
            'header_js' => 'nullable|string',
            'body_js' => 'nullable|string',
            'footer_js' => 'nullable|string',
        ];
    }
}
