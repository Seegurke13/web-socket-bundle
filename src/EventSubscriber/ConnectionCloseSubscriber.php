<?php


namespace Seegurke13\WebSocketBundle\EventSubscriber;


use Seegurke13\WebSocketBundle\Event\ConnectionCloseEvent;
use Seegurke13\WebSocketBundle\Service\ConnectionStore;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConnectionCloseSubscriber implements EventSubscriberInterface
{
    /**
     * @var ConnectionStore
     */
    private ConnectionStore $connectionStore;

    public function __construct(ConnectionStore $connectionStore)
    {
        $this->connectionStore = $connectionStore;
    }

    public static function getSubscribedEvents()
    {
        return [
            ConnectionCloseEvent::class => 'onConnectionClose'
        ];
    }

    public function onConnectionClose(ConnectionCloseEvent $closeEvent)
    {
        $this->connectionStore->detach($closeEvent->getConnection());
    }
}