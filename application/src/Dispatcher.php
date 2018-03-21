<?php
namespace Application;

use Core\EventManager\EventListenerInterface;
use Core\EventManager\EventManagerInterface;
use Core\EventManager\EventInterface;
use Elevator\Module as Elevator;
use Level\Module as Level;
use Winch\Module as Winch;

class Dispatcher implements EventListenerInterface
{
    private $elevator;

    private $levels;

    private $winch;

    private $eventManager;

    private $callsQueue = [];

    private $userChoiceQueue = [];

    public function __construct(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
        $this->eventManager->addEventListener($this);
        $this->elevator = new Elevator();
        $this->levels = [
            new Level($eventManager, 0, 1, 0),
            new Level($eventManager, 1, 1, 1),
            new Level($eventManager, 2, 1, 1),
            new Level($eventManager, 3, 1, 1),
            new Level($eventManager, 4, 0, 1),
        ];

        $this->winch = new Winch($this->eventManager);
    }

    /*
     * Someone call Elevator to some level
     * @param $level
     * @param $direction
     */
    public function levelCall($level, $direction)
    {
        $calledLevel = $this->levels[$level];

        //if elevator on the station and doors is open, disable call buttons
        if ($this->winch->getCurrentLevel() === $level && $calledLevel->getDoors()->isOpen()) {
            return false;
        } else {
            $this->callsQueue[] = [$level, $direction];
            foreach ($calledLevel->getButtons() as $button) {
                if ($button->getDirection() == $direction) {
                    $button->Activate();
                }
            }
        }
    }

    public function doStartMove($level = false)
    {
        if ($this->winch->isFree()) {
            $call = array_shift($this->callsQueue);
            $this->winch->StartMove($call[0]);
        }
        else if($level)
        {
            $this->winch->StartMove($level);
        }
    }

    public function doMove()
    {
        $this->winch->Move();
    }

    public function CloseDoor($level)
    {
        sleep(5);
        if ($this->elevator->getCountPassengers() <= $this->elevator->getMaxPassengers()) {
            $this->levels[$level]->getDoors()->Close();
        }
    }

    public function onArriveToLevel($level)
    {
        $destination = $this->winch->getDestination();
        $direction = $this->winch->getDirection();

        if ($level == $destination)// We get destination
        {
            $this->winch->setDestination(false);
            $this->winch->setDirection(false);
            $this->winch->Free();
            foreach ($this->levels[$level]->getButtons() as $button)
            {
                $button->Deactivate();
            }
            $this->winch->getStation();
        }
        else
        {
            foreach ($this->callsQueue as $key =>$call) //$call = [level,$direction]
            {
                //if call from this level exist in queue stop elevator and take passengers
                if($call[0] == $level)
                {
                    if($call[1] == $direction)
                    {
                        $this->levels[$call[0]]->getButtonByDirection($call[1])->Deactivate();
                        $this->winch->getStation();
                        unset($this->callsQueue[$key]);
                    }
                }
            }
        }

        if ($this->winch->onStation()) {
            $this->levels[$level]->getDoors()->Open();
        } else {
            $this->winch->StartMove($destination);
        }
    }

    public function publish(EventInterface $event, $sessionId)
    {

    }

}