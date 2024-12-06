<?php

namespace Tec\Theme\Http\Requests;

use Tec\Support\Http\Requests\Request;

class RobotsTxtRequest extends Request
{
    public function rules(): array
    {
        return [
            'robots_txt_content' => 'nullable|string|max:2500',
            'robots_txt_file' => 'nullable|file|mimes:txt|max:2048',
        ];
    }
}
