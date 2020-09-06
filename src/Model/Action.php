<?php


namespace Seegurke13\WebSocketBundle\Model;


use Ratchet\ConnectionInterface;

class Action
{
    private $action;
    private $data;
    /**
     * @var ConnectionInterface
     */
    private ConnectionInterface $connection;

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    public function setConnection(ConnectionInterface $connection): void
    {
        $this->connection = $connection;
    }
}