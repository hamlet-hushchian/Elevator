<?php

namespace Core\EventManager;

interface EventListenerInterface
{
    /**
     * @param EventInterface $event
     * @param string $sessionId WebSocket session ID
     */
    public function publish(EventInterface $event, $sessionId);
}
