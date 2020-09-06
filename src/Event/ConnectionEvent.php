<?php


namespace Seegurke13\WebSocketBundle\Event;


use Ratchet\ConnectionInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ConnectionEvent extends Event
{
    protected ConnectionInterface $connection;

    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function getConnection(): ?ConnectionInterface
    {
        return $this->connection;
    }
}