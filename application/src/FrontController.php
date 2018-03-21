<?php
namespace Application;


use Core\EventManager\EventInterface;
use Core\EventManager\EventListenerInterface;
use Ratchet\Wamp\Topic;
use Ratchet\Wamp\WampServerInterface;
use Ratchet\ConnectionInterface;

class FrontController implements WampServerInterface, EventListenerInterface
{
    private $topics;
    private $dispatchers = [];

    /**
     * @param ConnectionInterface $conn
     * @param Topic|string $topic
     * @param string $event
     * @param array $exclude
     * @param array $eligible
     */
    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        try {
            $dispatcher = Router::run(
                (string)$topic,
                $event,
                $this,
                $this->getSessionId($conn),
                $this->getDispatcher($conn)
            );

            if ($dispatcher instanceof Dispatcher) {
                $this->addDispatcher($conn, $dispatcher);
            }
        } catch (\Exception $e) {
        }


    }

    /**
     * @param ConnectionInterface $conn
     * @return mixed
     */
    function onOpen(ConnectionInterface $conn)
    {

    }

    /**
     * @param ConnectionInterface $conn
     * @return mixed
     */
    function onClose(ConnectionInterface $conn)
    {
        // TODO: Implement onClose() method.
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Exception $e
     * @return mixed
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        // TODO: Implement onError() method.
    }

    /**
     * @param EventInterface $event
     * @param string $sessionId
     */
    public function publish(EventInterface $event, $sessionId)
    {

            $topicId = $event->getName();

            //send event's data to the client
            if (isset($this->topics[$topicId])) {

                $data = json_encode($event->getData());

                $this->topics[$topicId]->broadcast($data, [], [$sessionId]);

            }
        }

    /**
     * @param ConnectionInterface $conn
     * @param string $id
     * @param Topic|string $topic
     * @param array $params
     * @return mixed
     */
    function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        // TODO: Implement onCall() method.
    }

    /**
     * @param ConnectionInterface $conn
     * @param Topic|string $topic
     * @return mixed
     */
    function onSubscribe(ConnectionInterface $conn, $topic)
    {
        if ($topic instanceof Topic) {
            $this->topics[(string)$topic] = $topic;
        }
    }

    /**
     * @param ConnectionInterface $conn
     * @param Topic|string $topic
     * @return mixed
     */
    function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
        // TODO: Implement onUnSubscribe() method.
    }


    /**
     * @param ConnectionInterface $conn
     * @return string
     */
    private function getSessionId(ConnectionInterface $conn)
    {
        return (string)$conn->WAMP->sessionId;
    }


    private function getDispatcher(ConnectionInterface $conn)
    {
        $sessionId = $this->getSessionId($conn);

        if (!isset($this->dispatchers[$sessionId])) {
            return null;
        }

        return $this->dispatchers[$sessionId];
    }

    private function addDispatcher(ConnectionInterface $conn, Dispatcher $dispatcher)
    {
        $this->dispatchers[$this->getSessionId($conn)] = $dispatcher;
    }

    private function removeDispatcher(ConnectionInterface $conn)
    {
        unset($this->dispatchers[$this->getSessionId($conn)]);
    }
}