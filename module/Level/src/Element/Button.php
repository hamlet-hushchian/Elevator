<?php
namespace Level\Element;

use Core\EventManager\AbstractEventProvider;

class Button extends AbstractEventProvider
{
    private $level;
    private $direction; //0 - bottom, 1 - top.
    private $isActive = false;

    public function __construct(\Level\Module $level, $direction)
    {
        parent::__construct($level->eventManager);
        $this->level = $level;
        $this->direction = $direction;
    }

    public function getDirection()
    {
        return $this->direction;
    }

    public function isActive()
    {
        return $this->isActive;
    }

    public function Activate()
    {
        $this->isActive = true;
        $this->eventManager->createEvent(new \Level\Event\TurnedOn($this->level->getNumber(), $this->direction));
    }

    public function Deactivate()
    {
        $this->isActive = false;
        $this->eventManager->createEvent(new \Level\Event\TurnedOff($this->level->getNumber(), $this->direction));
    }

}