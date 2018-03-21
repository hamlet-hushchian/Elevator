<?php

namespace Winch\Event;

use Application\Event\LevelEvent;

class ArriveToLevel extends LevelEvent
{
    protected $name = 'application.winch.arrive_to_level';

    public function __construct($level)
    {
        parent::__construct($level);
    }

}
