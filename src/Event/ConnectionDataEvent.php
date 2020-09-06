<?php


namespace Seegurke13\WebSocketBundle\Event;



class ConnectionDataEvent extends ConnectionEvent
{
    protected ?array $action;
    protected string $message;

    public function setAction(array $action)
    {
        $this->action = $action;
    }

    public function getAction(): ?array
    {
        return $this->action;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}