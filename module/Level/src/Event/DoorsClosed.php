<?php
namespace Level\Event;

use Application\Event\LevelEvent;

class DoorsClosed extends LevelEvent
{
    protected $name = 'application.level.doors_close';

    public function __construct($level)
    {
        parent::__construct($level);
    }
}