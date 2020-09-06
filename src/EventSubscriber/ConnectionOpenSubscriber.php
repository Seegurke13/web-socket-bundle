<?php


namespace Seegurke13\WebSocketBundle\EventSubscriber;


use Seegurke13\WebSocketBundle\Event\ConnectionOpenEvent;
use Seegurke13\WebSocketBundle\Service\ConnectionStore;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConnectionOpenSubscriber implements EventSubscriberInterface
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
            ConnectionOpenEvent::class => 'onConnectionOpen'
        ];
    }

    public function onConnectionOpen(ConnectionOpenEvent $connectionOpenEvent)
    {
        $this->connectionStore->attach($connectionOpenEvent->getConnection());
    }
}