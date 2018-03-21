<?php
namespace Application;

use Core\EventManager\EventListenerInterface;

class Router
{
    public static function run(
        $eventName,
        Array $eventData,
        EventListenerInterface $eventListener,
        $sessionId,
        Dispatcher $dispatcher = null
    )
    {
        switch ($eventName) {
            case 'application.init':
                $dispatcher = new DispatcherFactory();
                $result = $dispatcher($eventListener,$sessionId);
                break;
            case 'application.level.call':
                $result = $dispatcher->levelCall((int)$eventData['level'], (int)$eventData['direction']);
                break;
            case 'application.winch.do_start_move':
                $result = $dispatcher->doStartMove();
                break;
            case 'application.winch.do_move':
                $result = $dispatcher->doMove();
                break;
            case 'application.dispatcher.on_arrive_to_level' :
                $result = $dispatcher->onArriveToLevel((int)$eventData['level']);
                break;
            case 'application.level.do_close_door':
                $result = $dispatcher->closeDoor((int)$eventData['level']);
                break;
            default:
                $result = false;
        }
        return $result;
    }
}