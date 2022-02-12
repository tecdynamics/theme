<?php

namespace Tec\Theme\Events;

use Tec\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class RenderingHomePageEvent extends Event
{
    use SerializesModels;
}
