<?php
namespace Level\Event;

use Core\EventManager\LevelEvent;

class TurnedOn extends LevelEvent
{
    protected $name = 'application.level.turned_on';
    protected $direction;

    public function __construct($level,$direction)
    {
        parent::__construct($level);
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