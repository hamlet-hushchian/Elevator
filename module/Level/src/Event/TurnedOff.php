<?php
namespace Level\Event;

use Application\Event\LevelEvent;

class TurnedOff extends LevelEvent
{
    protected $name = 'application.level.turned_off';
    protected $direction;
    protected $level;

    public function __construct($level, $direction)
    {
        parent::__construct($level);
        $this->level = $level;
        $this->direction = $direction;
    }

    public function getData()
    {
        return [
            'level' => $this->level,
            'direction' => $this->direction
        ];
    }
}