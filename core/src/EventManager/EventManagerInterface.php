<?php
namespace  Core\EventManager;

interface EventManagerInterface
{
    public function addEventListener(EventListenerInterface $eventListener);

    public function createEvent(EventInterface $event);
}