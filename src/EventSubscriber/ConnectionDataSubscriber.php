<?php


namespace Seegurke13\WebSocketBundle\EventSubscriber;


use Seegurke13\WebSocketBundle\Event\ConnectionDataEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConnectionDataSubscriber implements EventSubscriberInterface
{
    public function __construct()
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            ConnectionDataEvent::class => 'onDataReceived'
        ];
    }

    public function onDataReceived(ConnectionDataEvent $connectionDataEvent)
    {
        if ($connectionDataEvent->getMessage() === 'exit') {
            die();
        }
        $action = json_decode($connectionDataEvent->getMessage(), true);
        if ($action === null || array_key_exists('action', $action) === false) {
            throw new \Exception("Data is malformed. JSON decode failed");
        }
        $connectionDataEvent->setAction($action);
    }
}