<?php
namespace Core\EventManager;

class MoveEvent extends AbstractEvent
{
    protected $name = 'application.winch.move';
    protected $direction;

    public function __construct($direction)
    {
        $this->direction = $direction;
    }

    public function getData()
    {
        return [
          'direction' => $this->direction
        ];
    }
}