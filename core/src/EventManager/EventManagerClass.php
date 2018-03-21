<?php
namespace Core\EventManager;

class EventManagerClass implements EventManagerInterface
{
    /**
     * @var EventListenerInterface[]
     */
    private $eventListeners = [];

    /**
     * @var string WebSocket session ID
     */
    private $sessionId;

    /**
     * EventManager constructor.
     * @param string $sessionId
     */
    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }



    public function addEventListener(EventListenerInterface $eventListener)
    {
        $this->eventListeners[] = $eventListener;
    }

    public function createEvent(EventInterface $event)
    {
        foreach ($this->eventListeners as $eventListener)
        {
            $eventListener->publish($event, $this->sessionId);
        }
    }
}