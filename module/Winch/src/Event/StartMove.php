<?php
namespace Winch\Event;

use Core\EventManager\MoveEvent;

class StartMove extends MoveEvent
{
    protected $name = 'application.winch.start_move';

    public function __construct($direction)
    {
        parent::__construct($direction);
    }
}