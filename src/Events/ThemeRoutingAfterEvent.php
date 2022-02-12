<?php

namespace Tec\Theme\Events;

use Tec\Base\Events\Event;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Queue\SerializesModels;

class ThemeRoutingAfterEvent extends Event
{
    use SerializesModels;

    /**
     * @var Application|mixed
     */
    public $router;

    /**
     * ThemeRoutingBeforeEvent constructor.
     */
    public function __construct()
    {
        $this->router = app('router');
    }
}
