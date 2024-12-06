<?php

namespace Tec\Theme\Events;

use Tec\Base\Events\Event;

class RenderingSiteMapEvent extends Event
{
    public function __construct(public ?string $key = null)
    {
    }
}
