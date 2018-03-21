<?php
namespace Level\Element;

use Core\EventManager\AbstractEventProvider;

class Doors extends AbstractEventProvider
{
    private $isOpen = false;
    private $level;

    public function __construct(\Level\Module $level)
    {
        parent::__construct($level->eventManager);

        $this->level = $level;
    }

    public function isOpen()
    {
        return $this->isOpen;
    }

    public function Open()
    {
        $this->isOpen = true;
        $this->level->eventManager->createEvent(new \Level\Event\DoorsOpened($this->level->getNumber()));
    }

    public function Close()
    {
        $this->isOpen = false;
        $this->level->eventManager->createEvent(new \Level\Event\DoorsClosed($this->level->getNumber()));
    }
}