<?php


namespace Seegurke13\WebSocketBundle\Event;


use Seegurke13\WebSocketBundle\Model\Action;
use Symfony\Contracts\EventDispatcher\Event;

class ActionControllerEvent extends Event
{
    /**
     * @var callable
     */
    private $controller;
    private Action $action;
    private array $arguments = [];

    /**
     * ActionControllerEvent constructor.
     */
    public function __construct()
    {
    }

    public function setController(callable $controller)
    {
        $this->controller = $controller;
    }

    public function getController(): callable
    {
        return $this->controller;
    }

    public function setAction(Action $action)
    {
        $this->action = $action;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function addArgument($argument)
    {
        $this->arguments[] = $argument;
    }
}