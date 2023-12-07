<?php

namespace Tec\Theme\Events;

use Tec\Base\Events\Event;
use Tec\Slug\Models\Slug;
use Illuminate\Queue\SerializesModels;

class RenderingSingleEvent extends Event
{
    use SerializesModels;

    public function __construct(public Slug $slug)
    {
    }
}
