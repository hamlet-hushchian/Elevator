<?php
namespace Core\EventManager;



abstract class AbstractEventProvider
{
    /*
     * @var EventManagerInterface
     */
    protected $eventManager;

    public function __construct(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }
}