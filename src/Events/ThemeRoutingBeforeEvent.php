<?php

namespace Tec\Theme\Events;

use Tec\Base\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Routing\Router;

class ThemeRoutingBeforeEvent extends Event
{
    use SerializesModels;

    public function __construct(public Router $router)
    {
    }
}
