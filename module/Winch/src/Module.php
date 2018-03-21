<?php
namespace Winch;

use Core\EventManager\AbstractEventProvider;
use Core\EventManager\EventManagerInterface;

class Module extends AbstractEventProvider
{
    private $currentLevel = 0;
    private $destination = false;
    private $direction = false;
    private $free = true;
    private $onStation = false;
    private $speed = 3; // Second for level

    public function __construct(EventManagerInterface $eventManager)
    {
        parent::__construct($eventManager);
    }

    public function onStation()
    {
        return $this->onStation;
    }

    public function getStation()
    {
        $this->onStation = true;
    }

    public function leaveStation()
    {
        $this->onStation = false;
    }

    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function getDirection()
    {
        return $this->direction;
    }

    public function setDirection($direction)
    {
        $this->direction = $direction;
    }

    public function StartMove($level)
    {
        $this->Busy();
        $this->destination = $level;
        if($this->currentLevel == $this->destination)
        {
            $this->eventManager->createEvent(new Event\ArriveToLevel($this->currentLevel));
        }
        else
        {
            $next_level = $this->currentLevel > $level ? $this->currentLevel - 1 : $this->currentLevel + 1;
            $next_level = $next_level < 0 ? 0 : $next_level;
            $next_level = $next_level > 4 ? 4 : $next_level;
            $direction = $next_level > $this->currentLevel ? 2 : 1;


            $this->direction = $direction;

            $this->eventManager->createEvent(new Event\StartMove($direction));
        }

    }

    public function Move()
    {
        if($this->direction == 2)
            $this->currentLevel = $this->currentLevel + 1;
        if($this->direction == 1)
            $this->currentLevel = $this->currentLevel - 1;
        sleep($this->speed);
        $this->eventManager->createEvent(new Event\ArriveToLevel($this->currentLevel));

    }

    public function getCurrentLevel()
    {
        return $this->currentLevel;
    }

    public function isFree()
    {
        return $this->free;
    }

    public function Free()
    {
        $this->free = true;
    }

    public function Busy()
    {
        $this->free = false;
    }
}