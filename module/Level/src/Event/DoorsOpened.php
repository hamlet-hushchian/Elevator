<?php
namespace Level\Event;

use Application\Event\LevelEvent;

class DoorsOpened extends LevelEvent
{
    protected $name = 'application.level.doors_open';

    public function __construct($level)
    {
        parent::__construct($level);
    }
}