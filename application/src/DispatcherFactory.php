<?php
namespace Application;

use Core\EventManager\EventListenerInterface;
use Core\EventManager\EventManagerClass as eventManager;

class DispatcherFactory
{
    public function __invoke(EventListenerInterface $eventListener, $sessionId)
    {
        $eventManager = new eventManager($sessionId);
        $eventManager->addEventListener($eventListener);

        return new Dispatcher($eventManager);
    }
}